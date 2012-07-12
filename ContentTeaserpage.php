<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Nothing Interactive 2012 <https://www.nothing.ch/>
 * @author     Weyert de Boer <sprog@nothing.ch>
 * @author     Stefan Pfister <red@nothing.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

class ContentTeaserpage extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_teaserpage';


	/**
	 * Return if there are no files
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}


	/**
	 * Generate content element
	 */
	protected function compile()
	{
		$teasers = array();

		$objTeaser = $this->Database->prepare('SELECT * FROM tl_teaserpage ORDER BY name')->execute();
		while ($objTeaser->next())
		{
			$strImage = 'image';

			// get the file size of the image
			$objImage = new stdClass();
			$strTeaserImage = $this->getImage($objTeaser->image, 150, 100);
			$objImage->src = $strTeaserImage;

			if (is_file($objImage->src))
			{
				$imgSize = getimagesize($objImage->src);
				$objImage->imageSize = $imgSize[3];
			}

			$objPage = $this->Database->prepare('SELECT * FROM tl_page WHERE id=?')->execute($objTeaser->page);
			$strTeaserPageUrl = $this->generateFrontendUrl($objPage->row());

			//
			$teasers[] = array(
				'name'             => $objTeaser->name,
				'url'              => $strTeaserPageUrl,
				'image'            => $objImage,
				'description'      => $objTeaser->description
			);
		}

		$this->Template->teasers = array_values($teasers);
	}
}

?>