<?php
$rokstock = JPATH_SITE.DS.'modules'.DS.'mod_rokstock'.DS.'JSON.php';
if (!class_exists("Services_JSON")) {
	if (file_exists($rokstock)) include_once($rokstock);
	else include_once(YOURBASEPATH.DS.'JSON.php');
} else {
	if (!function_exists('json_encode') || !function_exists('json_decode')) {
		function json_encode($data) {
	        $json = new Services_JSON();
	        return( $json->encode($data) );
	    }
	
		function json_decode($data, $output_mode=false) {
			$param = $output_mode ? 16:null;
			$json = new Services_JSON($param);
	        return( $json->decode($data) );
	    }
	}
}

class sectionRows {
	
	var $mainSort = false; // Enable/Disable the vertical sorting for Main
	
	var $verticalCookie_name = "affinity_vertical";
	var $horizontalCookie_name = "affinity_horizontal";
	
	var $showcase = "";
	var $module_row1 = "";
	var $maincontent = "";
	var $bottomrow1 = "";
	var $bottomrow2 = "";
	var $joomla = null;
	var $list = array(
		'section-row1' => 'Showcase',
		'section-row2' => 'ModuleRow1',
		'section-row3' => 'MainContent',
		'section-row4' => 'BottomRow1',
		'section-row5' => 'BottomRow2'
	);
	
	var $horDefault = array(
		'section-row1' => array('row1-block1', 'row1-block2', 'row1-block3'),
		'section-row2' => array('row2-block1', 'row2-block2', 'row2-block3'),
		'section-row3' => array('main-body', 'rightcol'),
		'section-row4' => array('row4-block1', 'row4-block2', 'row4-block3'),
		'section-row5' => array('row5-block1', 'row5-block2', 'row5-block3')
	);
		
	function sectionRows(&$joomla) {
		
		$this->joomla = $joomla;
		$this->verticalCookie = $this->loadVerticalCookie();
		$this->horizontalCookie = $this->loadHorizontalCookie();
		
		$this->verticalCookie = array_unique(array_merge($this->verticalCookie, array_keys($this->list)));
		$this->horizontalCookie = $this->array_merge_recursive_distinct($this->horDefault, $this->horizontalCookie);
		
		foreach($this->list as $row => $func) call_user_func(array(&$this, "set" . $func));
		
	}
	
	function render() {
		foreach($this->verticalCookie as $row => $func) echo call_user_func(array(&$this, "get" . $this->list[$func]));
	}
	
	function loadVerticalCookie() {
		if (isset($_COOKIE[$this->verticalCookie_name])) $list = explode(',', urldecode(JRequest::getVar($this->verticalCookie_name,'COOKIE')));
		else $list = array_keys($this->list);
		
		return $list;
	}
	
	function loadHorizontalCookie() {
		if (isset($_COOKIE[$this->horizontalCookie_name])) {
			$list = urldecode(JRequest::getVar($this->horizontalCookie_name,'COOKIE'));
			$list = json_decode($list, true);
			foreach($list as $key => $row) {
				$list[$key] = $row;
			}
		}
		else $list = $this->horDefault;

		return $list;
	}
	
	function getShowcase() {
		if (!($this->joomla->countModules('showcase or showcase2 or showcase3'))) return;
		return $this->showcase;
	}
	
	function getModuleRow1() {
		if (!($this->joomla->countModules('user1 or user2 or user3'))) return;
		return $this->module_row1;
	}
	
	function getMainContent() {
		return $this->maincontent;
	}
	
	function getBottomRow1() {
		if (!($this->joomla->countModules('user4 or user5 or user6'))) return;
		return $this->bottomrow1;
	}
	
	function getBottomRow2() {
		if (!($this->joomla->countModules('user7 or user8 or user9'))) return;
		return $this->bottomrow2;
	}
	
	function setShowcase() {
		global $showcase_block, $showmod_width, $showcase2_block, $showcase3_block;
		$mClasses = modulesClasses('case1', false, 'extra');
		$row = 'section-row1';
		
		$this->showcase = '
		<div id="section-row1" class="section-row">
			<div id="showcase-surround">
				<div id="showcase" class="png"><div id="showcase2" class="png"><div id="showcase3" class="png">
					<div class="showcase-inner">
						<div id="showmodules" class="spacer'.$showmod_width.'">';
		
		
		
		function row1block1($t, $mClasses) {
			global $showcase_block;
						
			if ($t->joomla->countModules('showcase')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->showcase .= '
								<div class="block '.$mClasses['showcase'][0].'" style="width: '.$mClasses['showcase'][1].'px;">
									<div class="module-'.$showcase_block.'">
										<div id="row1-block1" class="row">'.$handle.'';
				$t->showcase .= body_surround($t->joomla, '<jdoc:include type="modules" name="showcase" style="main" />');
				$t->showcase .= '
										</div>
									</div>
								</div>';
			}
		}
		
		function row1block2($t, $mClasses) {
			global $showcase2_block;
			
			if ($t->joomla->countModules('showcase2')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->showcase .= '
								<div class="block '.$mClasses['showcase2'][0].'" style="width: '.$mClasses['showcase2'][1].'px;">
									<div class="module-'.$showcase2_block.'">
										<div id="row1-block2" class="row">'.$handle.'';
				$t->showcase .= body_surround($t->joomla, '<jdoc:include type="modules" name="showcase2" style="main" />');
				$t->showcase .= '
										</div>
									</div>
								</div>';
			}
		}
		
		function row1block3($t, $mClasses) {
			global $showcase3_block;
			
			if ($t->joomla->countModules('showcase3')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->showcase .= '
								<div class="block '.$mClasses['showcase3'][0].'" style="width: '.$mClasses['showcase3'][1].'px">
									<div class="module-'.$showcase3_block.'">
										<div id="row1-block3" class="row">'.$handle.'';
				$t->showcase .= body_surround($t->joomla, '<jdoc:include type="modules" name="showcase3" style="main" />');
				$t->showcase .= '
										</div>
									</div>
								</div>';
			}
		}
		
		foreach($this->horizontalCookie[$row] as $block) {
			$block = str_replace('-', '', $block);
			call_user_func($block, $this, $mClasses);
		}
		
		$rowhandle = '<div class="row-handle png"></div>';
		if ($this->joomla->params->get("sortableElementsVer", 1)  == 0) $rowhandle = "";

		$this->showcase .= '
						</div>
					</div>
				</div></div></div>
			</div>
			'.$rowhandle.'
		</div>';
		
		return $this->showcase;
	}
	
	function setModuleRow1() {
		global $mainmod_width, $user1_block, $user2_block, $user3_block;
		$mClasses = modulesClasses('case2'); 
		$row = 'section-row2';
		
		$this->module_row1 = '<div id="section-row2" class="section-row">
			<div id="mainmodules" class="spacer'.$mainmod_width.'">';
			
		function row2block1($t, $mClasses) {
			global $user1_block;
			
			if ($t->joomla->countModules('user1')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->module_row1 .= '
					<div class="block '.$mClasses['user1'][0].'" style="width: '.$mClasses['user1'][1].'px;">
						<div class="module-'.$user1_block.'">
							<div id="row2-block1" class="row">'.$handle.'';
				$t->module_row1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user1" style="main" />');
				$t->module_row1 .= '
							</div>
						</div>
					</div>';
			}
		}
		
		function row2block2($t, $mClasses) {
			global $user2_block;
			
			if ($t->joomla->countModules('user2')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->module_row1 .= '<div class="block '.$mClasses['user2'][0].'" style="width: '.$mClasses['user2'][1].'px;">
						<div class="module-'.$user2_block.'">
							<div id="row2-block2" class="row">'.$handle.'';
				$t->module_row1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user2" style="main" />');
				$t->module_row1 .= '
							</div>
						</div>
					</div>';
			}
		}
		
		function row2block3($t, $mClasses) {
			global $user3_block;
			
			if ($t->joomla->countModules('user3')) {
				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
				
				$t->module_row1 .= '<div class="block '.$mClasses['user3'][0].'" style="width: '.$mClasses['user3'][1].'px;">
						<div class="module-'.$user3_block.'">
							<div id="row2-block3" class="row">'.$handle.'';
				$t->module_row1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user3" style="main" />');
				$t->module_row1 .= '
							</div>
						</div>
					</div>';
			}
		}
		
		foreach($this->horizontalCookie[$row] as $block) {
			$block = str_replace('-', '', $block);
			call_user_func($block, $this, $mClasses);
		}
		
		$rowhandle = '<div class="row-handle png"></div>';
		if ($this->joomla->params->get("sortableElementsVer", 1)  == 0) $rowhandle = "";
		
		$this->module_row1 .= '
			</div>
			'.$rowhandle.'
		</div>';
		
		return $this->module_row1;
	}
	
	
	function setBottomRow1() {
		global $user4_block, $user5_block, $user6_block, $mainmod4_width;
		$mClasses = modulesClasses('case5');
		$row = 'section-row4';
		
		$this->bottomrow1 = '<div id="section-row4" class="section-row">
			<div id="bottom-main">
				<div id="mainmodules4" class="spacer'.$mainmod4_width.'">';
				
				function row4block1($t, $mClasses) {
					global $user4_block;
					if ($t->joomla->countModules('user4')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow1 .= '
						<div class="block '.$mClasses['user4'][0].'" style="width: '.$mClasses['user4'][1].'px;">
							<div class="module-'.$user4_block.'">
								<div id="row4-block1" class="row">'.$handle.'';
						$t->bottomrow1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user4" style="main" />');
						$t->bottomrow1 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				function row4block2($t, $mClasses) {
					global $user5_block;
				
					if ($t->joomla->countModules('user5')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow1 .= '
						<div class="block '.$mClasses['user5'][0].'" style="width: '.$mClasses['user5'][1].'px;">
							<div class="module-'.$user5_block.'">
								<div id="row4-block2" class="row">'.$handle.'';
						$t->bottomrow1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user5" style="main" />');
						$t->bottomrow1 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				function row4block3($t, $mClasses) {
					global $user6_block;
					
					if ($t->joomla->countModules('user6')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow1 .= '
						<div class="block '.$mClasses['user6'][0].'" style="width: '.$mClasses['user6'][1].'px;">
							<div class="module-'.$user6_block.'">
								<div id="row4-block3" class="row">'.$handle.'';
						$t->bottomrow1 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user6" style="main" />');
						$t->bottomrow1 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				foreach($this->horizontalCookie[$row] as $block) {
					$block = str_replace('-', '', $block);
					call_user_func($block, $this, $mClasses);
				}
				
				$rowhandle = '<div class="row-handle png"></div>';
				if ($this->joomla->params->get("sortableElementsVer", 1)  == 0) $rowhandle = "";
				
				$this->bottomrow1 .= '
				</div>
			</div>
			'.$rowhandle.'
		</div>';
	}
	
	function setBottomRow2() {
		global $user7_block, $user8_block, $user9_block, $mainmod5_width;
		$mClasses = modulesClasses('case6');
		$row = 'section-row5';
		
		$this->bottomrow2 = '<div id="section-row5" class="section-row">
			<div id="bottom-main2">
				<div id="mainmodules5" class="spacer'.$mainmod5_width.'">';
				
				function row5block1($t, $mClasses) {
					global $user7_block;
					
					if ($t->joomla->countModules('user7')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow2 .= '
						<div class="block '.$mClasses['user7'][0].'" style="width: '.$mClasses['user7'][1].'px;">
							<div class="module-'.$user7_block.'">
								<div id="row5-block1" class="row">'.$handle.'';
						$t->bottomrow2 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user7" style="main" />');
						$t->bottomrow2 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				function row5block2($t, $mClasses) {
					global $user8_block;
					
					if ($t->joomla->countModules('user8')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow2 .= '
						<div class="block '.$mClasses['user8'][0].'" style="width: '.$mClasses['user8'][1].'px;">
							<div class="module-'.$user8_block.'">
								<div id="row5-block2" class="row">'.$handle.'';
						$t->bottomrow2 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user8" style="main" />');
						$t->bottomrow2 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				function row5block3($t, $mClasses) {
					global $user9_block;
					
					if ($t->joomla->countModules('user9')) {
						$handle = '<div class="move-handle"></div>';
						if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
						
						$t->bottomrow2 .= '
						<div class="block '.$mClasses['user9'][0].'" style="width: '.$mClasses['user9'][1].'px;">
							<div class="module-'.$user9_block.'">
								<div id="row5-block3" class="row">'.$handle.'';
						$t->bottomrow2 .= body_surround($t->joomla, '<jdoc:include type="modules" name="user9" style="main" />');
						$t->bottomrow2 .= '
								</div>
							</div>
						</div>';
					}
				}
				
				foreach($this->horizontalCookie[$row] as $block) {
					$block = str_replace('-', '', $block);
					call_user_func($block, $this, $mClasses);
				}
				
				$rowhandle = '<div class="row-handle png"></div>';
				if ($this->joomla->params->get("sortableElementsVer", 1)  == 0) $rowhandle = "";
				
				$this->bottomrow2 .= '
				</div>
			</div>
			'.$rowhandle.'
		</div>';
	}
	
	function setMainContent() {
		global $mainbody_block, $editmode, $side_block, $subnav, $active, $splitmenu_col, $leftcolumn_width, $rightcolumn_width, $mainmod2_width, $frontpage_component, $mainmod3_width;
		$row = 'section-row3';
		
		$cases = array(
			'case3' => modulesClasses('case3'),
			'case4' => modulesClasses('case4')
		);

		$this->maincontent = '<div id="section-row3" class="section-row"><div id="section-row3-inner">
			<div id="main-body-surround" class="spacer">';
			
		function mainbody($t, $c) {
				global $mainbody_block, $leftcolumn_width, $mainmod2_width, $editmode, $frontpage_component, $mainmod3_width, $leftcolumn_width, $splitmenu_col, $subnav, $active;
			
				$t->maincontent .= '<div id="main-body" class="spacing">
						<div class="module-'.$mainbody_block.'">';
					
						$main = '
							<div id="main-content">';
						
							if ($leftcolumn_width != 0) $main .= '<div id="maincol">';
							else $main .= '<div id="maincol2">';
						
							$main .= '
			  						<div class="maincol-padding">';
						
							$mClasses = $c['case3']; 
							if ($t->joomla->countModules('main1') or $t->joomla->countModules('main2') or $t->joomla->countModules('main3')) {
							
								$main .= '<div id="mainmodules2" class="spacer'.$mainmod2_width.'">';
							
								if ($t->joomla->countModules('main1')) {
									$main .= '<div class="block '.$mClasses['main1'][0].'">';
									$main .= '<jdoc:include type="modules" name="main1" style="main" />';
									$main .= '</div>';
								}
							
								if ($t->joomla->countModules('main2')) {
									$main .= '<div class="block '.$mClasses['main2'][0].'">';
									$main .= '<jdoc:include type="modules" name="main2" style="main" />';
									$main .= '</div>';
								}
							
								if ($t->joomla->countModules('main3')) {
									$main .= '<div class="block '.$mClasses['main3'][0].'">';
									$main .= '<jdoc:include type="modules" name="main3" style="main" />';
									$main .= '</div>';
								}
							
								$main .= '</div>';
							}
						
							if ($t->joomla->countModules('breadcrumb')) {
								$main .= '<div id="breadcrumbs"><div id="breadcrumbs2"><div id="breadcrumbs3">';
								$main .= '<a href="'.$t->joomla->baseurl.'" id="breadcrumbs-home"></a>';
								$main .= '<jdoc:include type="modules" name="breadcrumb" style="none" />';
								$main .= '</div></div></div>';
							}
						
							$main .= '
			  							<div class="bodycontent">
											<div class="mainbody-surround">';
						
							if ($t->joomla->countModules('inset2') and !$editmode) {
								$main .= '<div id="inset-block-right"><div class="right-padding">';
								$main .= '<jdoc:include type="modules" name="inset2" style="sidebar" />';
								$main .= '</div></div>';
			   				}
						
							if ($t->joomla->countModules('inset') and !$editmode) {
			   					$main .= '<div id="inset-block-left"><div class="left-padding">';
								$main .= '<jdoc:include type="modules" name="inset" style="sidebar" />';
			   					$main .= '</div></div>';
			   				}
		
							$main .= '
			   									<div id="maincontent-block">
													<jdoc:include type="message" />';
												
							if (!($frontpage_component == 'hide' and JRequest::getVar('view') == 'frontpage')) {
								$main .= '<jdoc:include type="component" />';
							}
						
							$main .= '
			   									</div>
												<div class="mainbody-tl"></div><div class="mainbody-tr"></div><div class="mainbody-bl"></div><div class="mainbody-br"></div>
											</div>
			  							</div>';	
						
							$mClasses = $c['case4']; 
							if ($t->joomla->countModules('main4') or $t->joomla->countModules('main5') or $t->joomla->countModules('main6')) {
								$main .= '<div id="mainmodules3" class="spacer'.$mainmod3_width.'">';

								if ($t->joomla->countModules('main4')) {
									$main .= '<div class="block '.$mClasses['main4'][0].'">';
									$main .= '<jdoc:include type="modules" name="main4" style="main" />';
									$main .= '</div>';
								}
							
								if ($t->joomla->countModules('main5')) {
									$main .= '<div class="block '.$mClasses['main5'][0].'">';
									$main .= '<jdoc:include type="modules" name="main5" style="main" />';
									$main .= '</div>';
								}
							
								if ($t->joomla->countModules('main6')) {
									$main .= '<div class="block '.$mClasses['main6'][0].'">';
									$main .= '<jdoc:include type="modules" name="main6" style="main" />';
									$main .= '</div>';
								}
							
								$main .= '
										</div>';
							}
						
							$main .= '
			  						</div>
			  					</div>    
							</div>';
						
							# Begin Left Column
						
							if ($leftcolumn_width != 0) {
								$main .= '
									<div id="leftcol">
					                	<div id="leftcol-bg">';
							
								if ($subnav and $splitmenu_col=="leftcol") {
//									$main .= '<div class="sidenav-block">';
									$main .= $subnav;
//									$main .= '</div>';
								}
							
								$main .= '<jdoc:include type="modules" name="left" style="sidebar" />';
							
								if (!isset($active)) {
									$main .= '<jdoc:include type="modules" name="inactive" style="sidebar" />';
								}
							
								$main .= '
					                	</div>
									</div>';
							}
							# End Left Column
						
						
			$t->maincontent .= body_surround($t->joomla, $main);
			
			$handle = '<div class="move-handle"></div>';
			if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";
			
			$t->maincontent .= '
					</div>
					'.$handle.'
				</div>';
		
		}
		
		// 'main-body', 'rightcol'
		function rightcol($t, $c) {
			global $rightcolumn_width, $side_block, $subnav, $splitmenu_col;
			
			# Begin Right Side Block
			if ($rightcolumn_width != 0) {
				$t->maincontent .= '
					<div id="rightcol">
						<div class="rightcol-padding">
							<div class="module-'.$side_block.'">';
						
							$right = "";
							if ($subnav and $splitmenu_col=="rightcol") {
								$right .= '<div class="sidenav-block">'.$subnav.'</div>';
							}
							$right .= '<jdoc:include type="modules" name="right" style="sidebar" />';
						
				$t->maincontent .= body_surround($t->joomla, $right);

				$handle = '<div class="move-handle"></div>';
				if ($t->joomla->params->get("sortableElements", 1)  == 0) $handle = "";

				$t->maincontent .= '		
							</div>
						</div>
						'.$handle.'
					</div>';
			}
			# End Right Side Block
		}
				
		foreach($this->horizontalCookie[$row] as $block) {
			$block = str_replace('-', '', $block);
			call_user_func($block, $this, $cases);
		}
		
		$rowhandle = '<div class="row-handle png"'.((!$this->mainSort) ? ' style="display: none;"' : '') .'></div>';
		if ($this->joomla->params->get("sortableElementsVer", 1)  == 0) $rowhandle = "";
		
		$this->maincontent .= '</div></div>';
		$this->maincontent .= $rowhandle;
		$this->maincontent .= '</div>';
	}
	
	function &array_merge_recursive_distinct(&$array1, &$array2)
	{
	  $merged = $array1;
	  if (is_array($array2))
	    foreach ($array2 as $key => $val)
	      if (is_array($array2[$key]))
	        $merged[$key] = is_array($merged[$key]) ? $this->array_merge_recursive_distinct($merged[$key], $array2[$key]) : $array2[$key];
	      else
	        $merged[$key] = $val;

	  return $merged;
	}
}

?>
