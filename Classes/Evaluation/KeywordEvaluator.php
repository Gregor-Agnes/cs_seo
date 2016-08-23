<?php
namespace Clickstorm\CsSeo\Evaluation;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Marc Hirdes <hirdes@clickstorm.de>, clickstorm GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class KeywordEvaluator
 * @package Clickstorm\CsSeo\Evaluation
 */
class KeywordEvaluator extends AbstractEvaluator
{

	public function evaluate() {
		$results = [];

		$state = self::STATE_RED;

		if(empty($this->keyword)) {
			$results['notSet'] = 1;
		} else {
			$results['titleContains'] = substr_count(strtolower($this->getSingleDomElementContentByTagName('title')), $this->keyword);
			$results['descriptionContains'] = substr_count(strtolower($this->getMetaTagContent('description')), $this->keyword);
			$results['bodyContains'] = substr_count(strtolower($this->getSingleDomElementContentByTagName('body')), $this->keyword);

			if($results['titleContains'] == 1 && $results['descriptionContains'] == 1 && $results['bodyContains'] > 0) {
				$state = self::STATE_GREEN;
			} else {
				$state = self::STATE_YELLOW;
			}
		}

		$results['state'] = $state;

		return $results;
	}

}