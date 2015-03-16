<?php

namespace Yeb\Helpers;

class View 
{

	static public function formGroup($id, $label, $content, $labelClass = null, $contentClass = null)
	{
 		$errors = \Session::get('errors', new \Illuminate\Support\MessageBag);
					
		$out = sprintf('<div class="form-group %s">', $errors->has('email') ? 'has-error' : '');

		if ($label) {
			$out.= sprintf(
				'<label for="%s" class="control-label %s" control-label">%s</label>',
				$id, $labelClass, $label
			);
		}

		$out.= sprintf(
			'<div class="%s">%s</div>%s</div>', 
			$contentClass,
			$content,
			$errors->first($id, '<p class="help-block">:message</p>')
		);

		return $out;
	}

	static public function showNotif($placement = null, $add_class = null, $close = true) 
	{

		$out = null;
		$message_type = ['success', 'info', 'warning', 'error'];
		foreach ($message_type as $type) {

			$flash_key = ($placement) ? $placement.'_'.$type : $type;

			if ( $message = \Session::get('flash_'.$flash_key, null, true) ) {
				
				if ($placement) {
					$out = '<div class="alert fade in '.$add_class.' alert-'.$type.'">';
					$close and $out.= '<button class="close" data-dismiss="alert" type="button">×</button>'; 
					$out.= $message.'</div>';
			
				} else {
					$class = ($add_class) ?: 'top-right';
					$out   = '<div class="notifications '.$class.'" data-type="'.$type.'" data-message="'. e($message).'"></div>';
				}
			}
		}

		return $out;
	}

	static public function spanLink($url, $label, $class = null)
	{
		return '
			<span onclick=\'document.location.href = "'.$url.'"; return false;\' class="'.$class.'">
				'.e($label).'
			</span>
		'; 
	}

	static public function portrait()
	{
		$friends = [839474,509394721,510327010,511498323,511813592,515027716,515652514,516889381,521817815,525316156,526114445,529086821,540872005,546220764,547392391,553049741,559153024,561129795,571771002,582903160,594877595,595920130,598767626,604669773,614071156,615537319,618180803,624883094,634915431,635285309,637217749,640842143,641454249,652373704,657729039,662529749,664623873,668542566,671566780,673363815,674183882,679343611,680255749,681563818,683553090,683853617,687897112,696641005,698426736,702369079,715803470,717491343,717592281,719925141,720693240,721271904,721445144,731136039,740282545,743232337,743779690,747110972,766243441,770588998,772469868,773027817,773743681,781531631,787412501,795702578,799028706,803500603,814722219,884040450,1002592473,1009245875,1037126892,1037486702,1038852410,1043573268,1057254076,1082072527,1128991269,1158087514,1185548160,1188881005,1194765287,1199855323,1200204924,1209855303,1221939479,1226557660,1244982188,1260432322,1274614598,1282915247,1312253026,1315514842,1322209718,1324441052,1347041505,1377094020,1440568246,1447219054,1450994543,1493441268,1498415431,1499971060,1530850499,1535718380,1579265542,1644698553,1646580784,1651226359,100000019090299,100000165166428,100000388890090,100000501368598,100001052795432,100001062482421,100001215347475,100001668439239,100001892514561,100001980238761,100002187521312,100002740863682,100002867303264,100003118593511,100003548139228,100004637283870,100006433828988];
		return 'http://graph.facebook.com/'.$friends[array_rand($friends)].'/picture?width=140&height=140';
	}

}
