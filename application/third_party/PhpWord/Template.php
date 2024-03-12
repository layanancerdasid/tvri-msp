<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2014 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord;

/**
 * @deprecated 0.12.0 Use \PhpOffice\PhpWord\TemplateProcessor instead.
 */
class Template extends TemplateProcessor
{
	 public function cloneRow($search, $numberOfClones) {
if(substr($search, 0, 2) !== '${' && substr($search, -1) !== '}') {
$search = '${'.$search.'}';
}
$tagPos = strpos($this->_documentXML, $search);
$rowStartPos = strrpos($this->_documentXML, "_documentXML) – $tagPos) " -1));
$rowEndPos = strpos($this->_documentXML, "", $tagPos) + 7;
$result = substr($this->_documentXML, 0, $rowStartPos);
$xmlRow = substr($this->_documentXML, $rowStartPos, ($rowEndPos – $rowStartPos));
for ($i = 1; $i <= $numberOfClones; $i++) {
$result .= preg_replace('/${(.*?)}/','${\1#'.$i.'}', $xmlRow);
}
$result .= substr($this->_documentXML, $rowEndPos);
$this->_documentXML = $result;
}

}
