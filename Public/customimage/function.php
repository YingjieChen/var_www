<?php
	function utf8_wordwrap($string, $width=75, $break="\n", $cut=false)
	{
		if($cut) {
			// Match anything 1 to $width chars long followed by whitespace or EOS,
			// otherwise match anything $width chars long
			$search = '/(.{1,'.$width.'})(?:\s|$)|(.{'.$width.'})/uS';
			$replace = '$1$2'.$break;
		} else {
			// Anchor the beginning of the pattern with a lookahead
			// to avoid crazy backtracking when words are longer than $width
			$pattern = '/(?=\s)(.{1,'.$width.'})(?:\s|$)/uS';
			$replace = '$1'.$break;
		}
		return preg_replace($search, $replace, $string);
	}

	function mb_wordwrap($str, $width = 75,$charset='utf-8',$break = "\n", $cut = false) {
		$lines = explode($break, $str);
		foreach($lines as &$line){
			$line = rtrim($line);
			if (mb_strlen($line,$charset) <= $width)
				continue;
			$words = explode(' ', $line);
			$line = '';
			$actual = '';
			foreach ($words as $word) {
				if (mb_strlen($actual.$word,$charset) <= $width)
					$actual .= $word.' ';
				else {
					if ($actual != '')
						$line .= rtrim($actual).$break;
						$actual = $word;
					if ($cut) {
						while (mb_strlen($actual,$charset) > $width) {
							$line .= mb_substr($actual, 0, $width,$charset).$break;
							$actual = mb_substr($actual, $width,null,'utf-8');
						}
					}
					$actual .= ' ';
				}
			}
			$line .= trim($actual);
		}
		return implode($break, $lines);
	}
?>
