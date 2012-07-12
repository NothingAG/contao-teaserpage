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

/**
 * Table tl_teaserpage
 */
$GLOBALS['TL_DCA']['tl_teaserpage'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'label'                       => &$GLOBALS['TL_LANG']['MOD']['references'][0],
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('name'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('page,description'),
			'format'                  => '%s',
			'label_callback'          => array('tl_teaserpage', 'createLabel')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit'   => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaserpage']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaserpage']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaserpage']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaserpage']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => 'name,image,page,description'
	),

	// Fields
	'fields' => array
	(
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaserpage']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>100)
		),
		'image' => array
		(
			'label'                        => &$GLOBALS['TL_LANG']['tl_teaserpage']['image'],
			'inputType'                    => 'fileTree',
			'eval'                         => array('mandatory'=>true, 'fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'jpg,jpeg,png,gif', 'tl_class'=>'clr'),
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaserpage']['description'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>500)
		),
		'page' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaserpage']['page'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'eval'                    => array('fieldType'=>'radio', 'mandatory'=>true, 'required'=>true)
		)
	)
);


class tl_teaserpage extends Backend
{

	/**
	 * add the title of the page instead of the id.
	 */
	public function createLabel($row)
	{
		if ($row['page'] == 0)
		{
			return '<strong>'. $GLOBALS['TL_LANG']['MSC']['noPageSelected'] . '</strong>';
		}

		$objPage = $this->Database->execute("SELECT p1.title, p2.title AS parentTitle FROM tl_page p1 LEFT JOIN tl_page p2 ON p1.pid=p2.id WHERE p1.id=" . $row["page"]);

		return '<strong>' . $objPage->parentTitle . " - " . $objPage->title . '</strong>' . ": " . $row["name"];
	}
}