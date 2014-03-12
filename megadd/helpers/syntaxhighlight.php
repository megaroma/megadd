<?php
namespace megadd\helpers
{
class SyntaxHighlight {

public static function process($s,$i = 1,$cur = "" ) {
        $s = htmlspecialchars($s);

        // Workaround for escaped backslashes
        $s = str_replace('\\\\','\\\\<e>', $s); 

        $regexp = array(

            // Comments/Strings
            '/(
                \/\*.*?\*\/|
                \/\/.*?\n|
                \#.[^a-fA-F0-9]+?\n|
                \&lt;\!\-\-[\s\S]+\-\-\&gt;|
                (?<!\\\)&quot;.*?(?<!\\\)&quot;|
                (?<!\\\)\'(.*?)(?<!\\\)\'
            )/isex' 
            => 'self::replaceId($tokens,\'$1\')',

            // Punctuations
            '/([\-\!\%\^\*\(\)\+\|\~\=\`\{\}\[\]\:\"\'<>\?\,\.\/]+)/'
            => '<span style="color:#9F9D65;">$1</span>',

            // Numbers (also look for Hex)
            '/(?<!\w)(
                (0x|\#)[\da-f]+|
                \d+|
                \d+(px|em|cm|mm|rem|s|\%)
            )(?!\w)/ix'
            => '<span style="color:#8CD0D3;">$1</span>',

            // Make the bold assumption that an
            // all uppercase word has a special meaning
            '/(?<!\w|>|\#)(
                [A-Z_0-9]{2,}
            )(?!\w)/x'
            => '<span style="color:#FFFFFF;">$1</span>',

            // Keywords
            '/(?<!\w|\$|\%|\@|>)(
                and|or|xor|for|do|while|foreach|as|return|die|exit|if|then|else|
                elseif|new|delete|try|throw|catch|finally|class|function|string|
                array|object|resource|var|bool|boolean|int|integer|float|double|
                real|string|array|global|const|static|public|private|protected|
                published|extends|switch|true|false|null|void|this|self|struct|
                char|signed|unsigned|short|long
            )(?!\w|=")/ix'
            => '<span style="color:#DFC47D;">$1</span>',

            // PHP/Perl-Style Vars: $var, %var, @var
            '/(?<!\w)(
                (\$|\%|\@)(\-&gt;|\w)+
            )(?!\w)/ix'
            => '<span style="color:#CEDF99;">$1</span>'

        );

        $tokens = array(); // This array will be filled from the regexp-callback

        $s = preg_replace(array_keys($regexp), array_values($regexp), $s);

        // Paste the comments and strings back in again
        $s = str_replace(array_keys($tokens), array_values($tokens), $s);

        // Delete the "Escaped Backslash Workaround Token" (TM)
        // and replace tabs with four spaces.
        $s = str_replace(array('<e>', "\t"), array('', '    '), $s);

		//mega test
		$buf="";
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $s) as $line){
		if($i == $cur) {
		$buf .= '<div style="background-color:#FF3333;"><div style="color:#666666;width:30px;float:left;">'.$i.'</div>'.$line."</div>"; 		
		} else
		{
		$buf .= '<div style="color:#666666;width:30px;float:left;">'.$i.'</div>'.$line."\n"; 
		}
		$i++;
        } 
		$s = $buf;
		
		//end mega test
        return '<pre style="display:block;
							background-color:#3F3F3F;
							margin:1em 0;
							padding:1em;
							font:normal normal 13px/1.4 Consolas,"Andale Mono WT","Andale Mono","Lucida Console","Lucida Sans Typewriter","DejaVu Sans Mono","Bitstream Vera Sans Mono","Liberation Mono","Nimbus Mono L",Monaco,"Courier New",Courier,Monospace;
							color:#E3CEAB;
							overflow:auto;
							white-space:pre;
							word-wrap:normal;">
		        <code style="font:inherit;color:inherit;">
				  ' . $s . '
				</code>
				</pre>';
    }

    // Regexp-Callback to replace every comment or string with a uniqid and save
    // the matched text in an array
    // This way, strings and comments will be stripped out and wont be processed
    // by the other expressions searching for keywords etc.
    private static function replaceId(&$a, $match) {
        $id = "##r" . uniqid() . "##";

        // String or Comment?
        if(substr($match, 0, 2) == '//' || substr($match, 0, 2) == '/*' || substr($match, 0, 2) == '##' || substr($match, 0, 7) == '&lt;!--') {
            $a[$id] = '<span style="color:#7F9F7F;">' . $match . '</span>';
        } else {
            $a[$id] = '<span style="color:#CC9385;">' . $match . '</span>';
        }
        return $id;
    }
}



}
?>