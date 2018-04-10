<?php
/**
 * Created by PhpStorm.
 * Date: 27.09.15
 * Time: 3:09
 */

namespace common\components;


use Aws\CloudFront\Exception\Exception;
use yii\base\Component;

class ImageManager extends Component
{
	/**
	 * @var string путь к папке, куда класть тумбочки в файловой системе
	 */
	public $thumbBasePath = '@app/web/thumbs';
	/**
	 * @var string url к папке с тумбочками который соответствует $thumbBasePath
	 */
	public $thumbBaseUrl = '/thumbs';

	public $noImageFile = '@app/web/img/no_image.png';

	public $webRoot = '@app/web';

	/**
	 * Оставляет верхнюю(или левую в зависимости от габаритов исходного изображения)
	 * часть картинки в тумбочке
	 */
	const THUMB_ADVANCED_TYPE_TOP_LEFT = 0;
	/**
	 * Оставляет нижнюю(или правую в зависимости от габаритов исходного изображения)
	 * часть картинки в тумбочке
	 */
	const THUMB_ADVANCED_TYPE_BOTTOM_RIGHT = 1;
	/**
	 * Оставляет центральную часть картинки в тумбочке
	 */
	const THUMB_ADVANCED_TYPE_CENTER = 2;

	/**
	 * Оставляет всю картинку в тумбочке и заливает не занятую картинкой область RGB цветом $background
	 */
	const THUMB_ADVANCED_TYPE_BACKGROUND = 3;


	const THUMB_TYPE_CENTER = 0;
	const THUMB_TYPE_FORCE = 1;
	const THUMB_TYPE_AUTO = 2;

	/**
	 * Делает тумбочку из картинки $imagePath шириной $width и высотой $height типа $type
	 * и возвращает массив содержащий путь к файлу и ссылку на него
	 * Если задоно только одна размерность, то другая вычисляется автоматически на основе
	 * габаритов исходного изображения
	 *
	 * @param $imagePath путь или алиас пути к исходному изображению
	 * @param null $cropWidth ширина тумбочки, если 0 - то будет вычислина пропорционально высоте тумбочки и габаритам исходного изображения
	 * @param null $cropHeight высота тумбочки, если 0 - то будет вычислина пропорционально ширине тумбочки и габаритам исходного изображения
	 * @param int $type правило создания тумбочки - одна из констант c префиксом THUMB_TYPE_
	 * @param int $background цвет заливки не занятой изображением части
	 * @return string[] ассоциативный массив с данными о результате работы ['file' => путь к файлу тумбочки, 'url' => url тумбочки]
	 */
	public function thumbAdvanced($imagePath, $cropWidth = 0, $cropHeight = 0, $type = self::THUMB_ADVANCED_TYPE_CENTER, $background = 0xFFF)
	{
		$resFile = [
			'file' => '',
			'url' => ''
		];

		$imagePath = \Yii::getAlias($imagePath);
		$image = new \Imagick($imagePath);
		$resImage = new \Imagick();

		$imageWidth = $image->getImageWidth();
		$imageHright = $image->getImageHeight();

		if ($cropWidth == 0 && $cropHeight == 0) {
			$cropWidth = $imageWidth;
		}

		if ($cropWidth == 0) {
			$cropHeight = (int)($imageHright * $cropWidth / $imageWidth);
		}
		if ($cropHeight == 0) {
			$cropWidth = (int)($cropHeight * $imageWidth / $imageHright);
		}
		$resImage->newImage($cropWidth, $cropHeight, $background);

		switch ($type) {
			case self::THUMB_ADVANCED_TYPE_CENTER:
				$image->cropThumbnailImage($cropWidth, $cropHeight);
				break;
			default:
				$image->thumbnailImage($cropWidth, $cropHeight, true);
				break;
		}

		return $resFile;
	}

	public function thumb($imagePath, $cropWidth = 0, $cropHeight = 0, $type = self::THUMB_TYPE_CENTER)
	{
		$imagePath = \Yii::getAlias($imagePath);
		if (!file_exists($imagePath)) {
			$imagePath = \Yii::getAlias($this->noImageFile);
		}

		$paramsStr = $imagePath . $cropWidth . $cropHeight . $type;
		$md5Params = md5($paramsStr);
		$pathInfo = pathinfo($imagePath);
		$fileName = $pathInfo['filename'];
		$ext = $pathInfo['extension'];

		$resFileName = 'thumb_' . $cropWidth . 'x' . $cropHeight . '_' . $type . '_' . $fileName;

		$outSubdir = $md5Params[0] . '/' . $md5Params[1] . '/' . $md5Params[2];
		$outDir = \Yii::getAlias($this->thumbBasePath) . '/' . $outSubdir;

		if (!file_exists($outDir)) {
			mkdir($outDir, 0777, true);
		}
		$outFile = $outDir . '/' . $resFileName . '.' . $ext;

		if (!file_exists($outFile)) {
			$image = new \Imagick($imagePath);
			switch ($type) {
				case self::THUMB_TYPE_CENTER:
					if (!$cropWidth) {
						$cropWidth = $cropHeight;
					}
					if (!$cropHeight) {
						$cropHeight = $cropWidth;
					}
					$image->cropThumbnailImage($cropWidth, $cropHeight);
					break;
				case self::THUMB_TYPE_FORCE:
					$image->thumbnailImage($cropWidth, $cropHeight);
					break;
				case self::THUMB_TYPE_AUTO:
					$image->thumbnailImage($cropWidth, $cropHeight, true);
					break;
			}
			$image->writeImage($outFile);
		}
		return [
			'file' => $outFile,
			'url' => $this->thumbBaseUrl . '/' . $outSubdir . '/' . $resFileName . '.' . $ext,
		];
	}

	public function thumbUrl($imagePath, $cropWidth = 0, $cropHeight = 0, $type = self::THUMB_TYPE_CENTER)
	{
		if(!$imagePath){
			$imagePath = '/<incorrect image>';
		}
        return $this->thumb($this->getFileForUri($imagePath), $cropWidth, $cropHeight, $type)['url'];
    }

	/**
	 * Вернет файл по его URI
	 * @param $uri string URI файла
	 */
	public function getFileForUri($uri)
	{
		$uri = urldecode($uri);
		return \Yii::getAlias($this->webRoot) . $uri;
	}
}