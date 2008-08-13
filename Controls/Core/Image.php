<?php
/**
 * Image class
 *
 * A Control for an Image. An Image can either be used to diplay a graphic or be used as a custom button. It can also
 * be used to render your own images using PHP's image magic functions by calling Conjure. Conjure can be used, to give 
 * but one example, for rendering a captua.
 * 
 * Example 1: Instantiating and Adding an Image
 *
 * <pre>
 * function Foo()
 * {
 *    //Instatiates $tmpImage as a new Image, with the src of SomePicture.gif, and a left, 
 *    //and top of 10px.
 *    $tmpImage = new Image("Images/SomePicture.gif", 10, 10);
 *    $this->Controls->Add($tmpImage); //Adds a button to the Controls of some Container
 * }     	
 * </pre>
 * 
 * @property string $Src The source file of this image
 * 
 * @package Controls/Core
 */
class Image extends Control 
{
	private $Src;
    private $Magician;
	/**
	* Constructor.
	* Be sure to call this from the constructor of any class that extends Button
 	* Example
 	*	<pre> $tempVar = new Image("Images/NOLOHLogo.gif", 0, 10);</pre>
 	* @param string $src
	* @param integer $left
	* @param integer $top
	* @param integer $width
	* @param integer $height
	*/
	function Image($src='', $left = 0, $top = 0, $width = System::Auto, $height = System::Auto)  
	{
		parent::Control($left, $top, null, null);
		if(!empty($src))
			$this->SetSrc($src);
		$this->SetWidth($width);
		$this->SetHeight($height);
	}
	/**
	* Gets the Src of the Image

	* @return string
 	*/
	function GetSrc()
	{
		return $this->Src;
	}
	/**
	*Sets the Src of the Image.

	*The path is relative to your main file 
	*<b>!Important!</b> If Overriding, make sure to call parent::SetSrc($newSrc)
	*@param string $src
	*@return string 
	*/
	function SetSrc($newSrc, $adjustSize=false)
	{
		$this->Src = $newSrc;
		if($this->Magician == null)
			NolohInternal::SetProperty('src', $newSrc, $this);
		else
			$this->SetMagicianSrc();
        //NolohInternal::SetProperty('src', $this->Magician == null ? $newSrc : ($_SERVER['PHP_SELF'].'?NOLOHImage='.GetAbsolutePath($this->Src).'&Class='.$this->Magician[0].'&Function='.$this->Magician[1].'&Params='.implode(',', array_slice($this->Magician, 2))), $this);
		if($adjustSize)
		{
			$this->SetWidth(System::Auto);
			$this->SetHeight(System::Auto);
		}
		return $newSrc;
	}
	/**
	*Gets the Width of the Image.

	*@param string $unit Units you would like the width in, either px, or "%".
	*@return mixed
	*/
	function GetWidth($unit='px')
	{
		if($unit == '%')
		{
			$tmpImageSize = getimagesize(GetAbsolutePath($this->Src));
			return parent::GetWidth()/$tmpImageSize[0] * 100;
		}
		else
			return parent::GetWidth();
	}
	/**
	*Sets the Width of the Image.

	*<b>!Important!</b> If Overriding, make sure to call parent::SetWidth($newWidth)
	*@param integer $width
	*/
	function SetWidth($width)
	{
		$tmpWidth = $width;
		if(!is_numeric($tmpWidth))
		{
			if(substr($width, -1) != '%')
			{
				$tmpImageSize = getimagesize(GetAbsolutePath($this->Src));
				if($tmpWidth == System::Auto)
					$tmpWidth = $tmpImageSize[0];
				else
				{
					$tmpWidth = intval($tmpWidth)/100;
					$tmpWidth = round($tmpWidth * $tmpImageSize[0]);
				}
			}
		}
		if($this->Magician != null)
			$this->SetMagicianSrc();
		parent::SetWidth($tmpWidth);
	}
	/**
	*Gets the Width of the Image.

	*@param string $unit Units you would like the height in, either px, or "%".
	*@return mixed
	*/
	function GetHeight($unit='px')
	{
		if($unit == '%')
		{
			$tmpImageSize = getimagesize(GetAbsolutePath($this->Src));
			return parent::GetHeight()/$tmpImageSize[1] * 100;
		}
		else
			return parent::GetHeight();
	}
	/**
	*Sets the Height of the Image.

	*<b>!Important!</b> If Overriding, make sure to call parent::SetHeight($newHeight)
	*@param integer $height
	*/
	function SetHeight($height)
	{
		$tmpHeight = $height;
		if(!is_numeric($tmpHeight))
		{
			if(substr($height, -1) != '%')
			{
				$tmpImageSize = getimagesize(GetAbsolutePath($this->Src));
				if($tmpHeight == System::Auto)
					$tmpHeight = $tmpImageSize[1];
				else
				{
					$tmpHeight = intval($tmpHeight)/100;
					$tmpHeight = round($tmpHeight * $tmpImageSize[1]);
				}
			}
		}
		if($this->Magician != null)
			$this->SetMagicianSrc();
		parent::SetHeight($tmpHeight);
	}
	/**
	 * Conjure can be used to render your own images on the fly, e.g., for creating captuas. It lets you specify a callback function, which MUST
	 * be static, whose first parameter is the image resource, and subsequent parameters can be anything you define. One can then call PHP's image 
	 * magic functions on the image resource. Consider the following example:
	 * <pre>
	 * class Example
	 * {
	 *  function Example()
	 *  {
	 *   // Instantiate a new Image
	 *   $image = new Image('me.jpg');
	 *   // Conjure a magician for performing the image magic, passing in the parameters 255, 0, 0, which will correspond to red in our function
	 *   $image->Conjure('Example', 'FillImage', 255, 0, 0);
	 *  }
	 *  function FillImage($resource, $red, $green, $blue)
	 *  {
	 *   // Create a color using PHP's imagecollorallocate function
	 *   $col = imagecolorallocate($resource, $red, $green, $blue);
	 *   // Fill in the image with this color, using PHP's imagefill function
	 *   imagefill($resource, 5, 5, $col);
	 *  }
	 * }
	 * </pre>
	 * @param string $className
	 * @param string $functionName
	 * @param mixed,... $paramsAsDotDotDot
	 */
    function Conjure($className, $functionName, $paramsAsDotDotDot = null)
    {
		$this->Magician = func_get_args();
		$this->SetMagicianSrc();
        //NolohInternal::SetProperty('src', $_SERVER['PHP_SELF'].'?NOLOHImage='.GetAbsolutePath($this->Src).'&Class='.$className.'&Function='.$functionName.'&Params='.implode(',', array_slice($this->Magician, 2)), $this);
        //$this->Magician = array($className, $functionName);
    }
	/**
	* @ignore
	*/
	private function SetMagicianSrc()
	{
		if($this->Src)
			NolohInternal::SetProperty('src', $_SERVER['PHP_SELF'].'?NOLOHImage='.GetAbsolutePath($this->Src).'&Class='.$this->Magician[0].'&Function='.$this->Magician[1].'&Params='.urlencode(implode(',', array_slice($this->Magician, 2))), $this);
		else
			NolohInternal::SetProperty('src', $_SERVER['PHP_SELF'].'?NOLOHImage='.GetAbsolutePath($this->Src).'&Class='.$this->Magician[0].'&Function='.$this->Magician[1].'&Params='.urlencode(implode(',', array_slice($this->Magician, 2))).'&Width='.$this->GetWidth().'&Height='.$this->GetHeight(), $this);
	}
	/**
	* @ignore
	*/
	function Show()
	{
		NolohInternal::Show('IMG', parent::Show(), $this);
	}
	/**
	 * @ignore
	 */
	function SearchEngineShow()
	{
		echo '<IMG src="', $this->Src, '"', $this->ToolTip===null?'':(' alt="'.$this->ToolTip.'"'), '></IMG> ';
	}
	/**
	 *@ignore 
	*/
	static function MagicGeneration($src, $class, $function, $params, $width=300, $height=200)
	{
		if($src != '')
		{
			$splitString = explode('.', $src);
			$extension = strtolower($splitString[count($splitString)-1]);
			if($extension == 'jpg')
				$extension = 'jpeg';
			elseif($extension == 'bmp')
				$extension = 'wbmp';
			//eval('if(imagetypes() & IMG_'.strtoupper($extension).')' .
			//	'$im = imagecreatefrom'.$extension.'($src);');
			if(imagetypes() & constant('IMG_'.strtoupper($extension)))
				$im = call_user_func('imagecreatefrom'.$extension, $src);
		}
		else
		{
			$extension = 'png';
			$im = imagecreatetruecolor($width, $height);
			$white = imagecolorallocate($im, 255, 255, 255);
			imagefill($im, 0, 0, $white);
		}
		if($im)
		{
			call_user_func_array(array($class, $function), array_merge(array($im), explode(',', urldecode($params))));
			header('Content-type: image/'.$extension);
			call_user_func('image'.$extension, $im);
			imagedestroy($im);
		}
	}
	/**
	 * ShiftColor can be used to dynamically rotate the colors of your image. This is useful for skinning objects.
	 * ShiftColor maintains all transparency and gradients. For instance, if you have a gradient image that has a blue base you can change
	 * that image to be based on whichever color you wish and it will maintain the look and feel of the image.
	 * 
	 * ShiftColor works with gif, png, and jpeg.
	 * <pre>
	 * class Example
	 * {
	 *  function Example()
	 *  {
	 *		// Instantiate a new Image
	 *		$image = new Image('titlebar.gif');
	 *	 	Image::ShiftColor($image, '#CC0000');
	 *  }
	 * }
	 * </pre>
	 * @param image|array $image The image or array of images that will have their colors rotated
	 * @param string $toColor The color that you would like the image to be based on.
	 * @param string $fromColor The color that you would like the rotation to start from. This is useful if you wish to preserve certain colors
	 * or have a different starting based. By default the color range begins from the darkest color in your image.
	 */
	static function ShiftColor($image, $toColor, $fromColor=null)
	{
		
	}
}
?>