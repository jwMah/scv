<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="register">
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
    <?php } ?>

    <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <?php
    if(!isset($reg_type)){
		$reg_type=$member['mb_10'];
	}?>
	<input type="text" name="mb_10" value="<?php echo $reg_type?>" hidden>
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php } ?>

    <div class="form_01">
        <h2>사이트 이용정보 입력</h2>
        <ul>
            <li class="reg_mb_img_file">
                <div>
	                <label for="reg_mb_img" class="frm_label">
	                	<b>회원이미지</b>
	                <input type="file" name="mb_img" id="reg_mb_img" style="float:right;">
                </div>
                    <span class="frm_info"><i class="far fa-question-circle" aria-hidden="true"></i> 이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>
	                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.</span>
	                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
	                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
	                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
	                <label for="del_mb_img" class="inline">삭제</label>
	                <?php }  ?>
	            
	        </li>
            
	        <li>
	            <label for="reg_mb_id" class="sound_only">아이디<strong>필수</strong></label>
	            <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" <?php echo $required ?> <?php echo $readonly ?> placeholder="아이디">
	            <span id="msg_mb_id"></span>
	            <span class="frm_info"><i class="far fa-question-circle" aria-hidden="true"></i> 영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span>
	        </li>
	        <li class="password">
	            <label for="reg_mb_password" class="sound_only">비밀번호<strong>필수</strong></label>
	            <input type="password" name="mb_password" id="reg_mb_password" class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?> placeholder="비밀번호">
	        </li>
	        <li>
	            <label for="reg_mb_password_re" class="sound_only">비밀번호 확인<strong>필수</strong></label>
	            <input type="password" name="mb_password_re" id="reg_mb_password_re" class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?>  placeholder="비밀번호확인">
	        </li>
        </ul>
    </div>

    <div class="form_01">
        <h2>개인정보 입력</h2>
        <ul>
	        <li class="rgs_name_li">
	            <label for="reg_mb_name" class="sound_only">이름<strong>필수</strong></label>
	            <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" placeholder="이름">
	            <?php
	            if($config['cf_cert_use']) {
	                if($config['cf_cert_ipin'])
	                    echo '<button type="button" id="win_ipin_cert" class="btn_frmline btn">아이핀 본인확인</button>'.PHP_EOL;
	                if($config['cf_cert_hp'])
	                    echo '<button type="button" id="win_hp_cert" class="btn_frmline btn">휴대폰 본인확인</button>'.PHP_EOL;
	
	                echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
	            }
	            ?>
	            <?php
	            if ($config['cf_cert_use'] && $member['mb_certify']) {
	                if($member['mb_certify'] == 'ipin')
	                    $mb_cert = '아이핀';
	                else
	                    $mb_cert = '휴대폰';
	            ?>
	            <?php if ($config['cf_cert_use']) { ?>
	            <span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
	            <?php } ?>
	            <div id="msg_certify">
	                <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
	            </div>
	            <?php } ?>
	        </li>
	        <?php if ($req_nick) { ?>
	        <li>
	            <label for="reg_mb_nick" class="sound_only">닉네임<strong>필수</strong></label>
	            <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
	            <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input full_input required nospace" maxlength="20" placeholder="닉네임">
	            <span id="msg_mb_nick"></span>

	            <span class="frm_info">
                    <i class="far fa-question-circle" aria-hidden="true"></i> 공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
                    <i class="far fa-question-circle" aria-hidden="true"></i> 닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
	            </span>
	            
	        </li>
	        <?php } ?>
            <li>
		        <label for="reg_mb_email" class="sound_only">E-mail<strong class="sound_only">필수</strong></label>
		        <?php if ($config['cf_use_email_certify']   ) {  ?>
		        <span class="frm_info">
		            <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
		            <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
		        </span>
		        <?php }  ?>
		        <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
		        <input type="email" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required" size="50" maxlength="100" placeholder="E-mail">
		    </li>
        </ul>
    </div>

    <!-- 건설사면 출력 -->
    <?php if ($reg_type=='constructor'||$is_constructor) { ?>
    <div class="form_01">
        <h2>건설사 정보</h2>
        <ul>
            <!-- 건설사 정보 시작 -->
            <li>
	            <label for="reg_mb_com_name" class="sound_only">회사명<strong class="sound_only">필수</strong></label>
	            <input type="text" name="mb_1" value="<?php echo get_text($member['mb_1']) ?>" id="reg_mb_com_name" <?php echo "required" ?> class="frm_input full_input <?php echo "required" ?>" maxlength="20" placeholder="회사명">
			</li>

            <li>
	            <label for="reg_mb_tel" class="sound_only">회사 연락처<?php //if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php //} ?></label>
	            <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo "required"//echo $config['cf_req_tel']?"required":""; ?> class="frm_input full_input <?php echo "required"//echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="회사 연락처">
			</li>

			<li>
	            <label for="reg_mb_hp" class="sound_only">담당자 연락처<strong class="sound_only">필수</strong></label>
	            <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo "required"//echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo "required"//echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="담당자 연락처">
	            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	            <?php } ?>
	        </li> 

			<li>
				<label for="reg_mb_com_code">사업자 등록번호<strong class="sound_only">필수</strong></label>
	            <input type="text" name="mb_2" value="<?php echo get_text($member['mb_2']) ?>" id="reg_mb_com_code" <?php echo "required" ?> class="frm_input full_input <?php echo "required" ?>" maxlength="20" placeholder="-를 빼고 입력해주세요.">
			</li>
			<!-- 건설사 정보 끝 -->

		    <!-- 건설사일시 주소입력 -->
			<li>
				<label>회사 주소</label>
				<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
				<label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
				<input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $fig['cf_req_addr']?"required":""; ?> class="frm_input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호" readonly onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">
				<button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
				<input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소" readonly>
				<label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
				<input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
				<label for="reg_mb_addr2" class="sound_only">상세주소</label>
				<br>
				<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
				<label for="reg_mb_addr3" class="sound_only">참고항목</label>
				<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
			</li>
        </ul>
    </div>
    <?php }  ?>

    <!-- 근로자면 출력 -->
    <?php if ($reg_type=='worker'||$is_worker) {?>
    
    <!-- 직종 정보 -->
	<div class="form_01">
	    <h2>직종 정보</h2>
	    <ul>
            <li>
				<label>조공</label>
				<input type="checkbox" name="mb_5[]" value="일반공(잡부)"<?php if(strpos($member['mb_5'], "일반공(잡부)")!==false) echo ' checked';?>> 일반공(잡부)
				<input type="checkbox" name="mb_5[]" value="조력공(조공)"<?php if(strpos($member['mb_5'], "조력공(조공)")!==false) echo ' checked';?>> 조력공(조공)
				<input type="checkbox" name="mb_5[]" value="청소"<?php if(strpos($member['mb_5'], "청소")!==false) echo ' checked';?>> 청소
				<input type="checkbox" name="mb_5[]" value="비계(아시바)"<?php if(strpos($member['mb_5'], "비계(아시바)")!==false) echo ' checked';?>> 비계(아시바)
				<input type="checkbox" name="mb_5[]" value="철거(해체)"<?php if(strpos($member['mb_5'], "철거(해체)")!==false) echo ' checked';?>> 철거(해체)
				<input type="checkbox" name="mb_5[]" value="할석공(하스리)"<?php if(strpos($member['mb_5'], "할석공(하스리)")!==false) echo ' checked';?>> 할석공(하스리)
				<input type="checkbox" name="mb_5[]" value="운반공(곰방)"<?php if(strpos($member['mb_5'], "운반공(곰방)")!==false) echo ' checked';?>> 운반공(곰방)
				<input type="checkbox" name="mb_5[]" value="기타(조공)"<?php if(strpos($member['mb_5'], "기타(조공)")!==false) echo ' checked';?>> 기타(조공)
			</li>
			<li>
				<label>기공</label>
				<input type="checkbox" name="mb_5[]" value="목수(목공)"<?php if(strpos($member['mb_5'], "목수(목공)")!==false) echo ' checked';?>> 목수(목공)
				<input type="checkbox" name="mb_5[]" value="용접공"<?php if(strpos($member['mb_5'], "용접공")!==false) echo ' checked';?>> 용접공
				<input type="checkbox" name="mb_5[]" value="설비"<?php if(strpos($member['mb_5'], "설비")!==false) echo ' checked';?>> 설비
				<input type="checkbox" name="mb_5[]" value="조경"<?php if(strpos($member['mb_5'], "조경")!==false) echo ' checked';?>> 조경
				<input type="checkbox" name="mb_5[]" value="미장공"<?php if(strpos($member['mb_5'], "미장공")!==false) echo ' checked';?>> 미장공
				<input type="checkbox" name="mb_5[]" value="타일공"<?php if(strpos($member['mb_5'], "타일공")!==false) echo ' checked';?>> 타일공
				<input type="checkbox" name="mb_5[]" value="석재"<?php if(strpos($member['mb_5'], "석재")!==false) echo ' checked';?>> 석제
				<input type="checkbox" name="mb_5[]" value="조적공(쓰미)"<?php if(strpos($member['mb_5'], "조적공(쓰미)")!==false) echo ' checked';?>> 조적공(쓰미)
				<input type="checkbox" name="mb_5[]" value="콘크리트공(타설)"<?php if(strpos($member['mb_5'], "콘크리트공(타설)")!==false) echo ' checked';?>> 콘크리트공(타설)
				<input type="checkbox" name="mb_5[]" value="방수"<?php if(strpos($member['mb_5'], "방수")!==false) echo ' checked';?>> 방수
				<input type="checkbox" name="mb_5[]" value="철근공"<?php if(strpos($member['mb_5'], "철근공")!==false) echo ' checked';?>> 철근공
				<input type="checkbox" name="mb_5[]" value="전기"<?php if(strpos($member['mb_5'], "전기")!==false) echo ' checked';?>> 전기
				<input type="checkbox" name="mb_5[]" value="로프공"<?php if(strpos($member['mb_5'], "로프공")!==false) echo ' checked';?>>로프공
				<input type="checkbox" name="mb_5[]" value="기타(기공)"<?php if(strpos($member['mb_5'], "기타(기공)")!==false) echo ' checked';?>> 기타(기공)
				<input type="checkbox" name="mb_5[]" value="도장공(페인트공)"<?php if(strpos($member['mb_5'], "도장공(페인트공)")!==false) echo ' checked';?>> 도장공(페인트공)
			</li>
			<li>
				<label>파출</label>
				<input type="checkbox" name="mb_5[]" value="가사"<?php if(strpos($member['mb_5'], "가사")!==false) echo ' checked';?>> 가사
				<input type="checkbox" name="mb_5[]" value="육아"<?php if(strpos($member['mb_5'], "육아")!==false) echo ' checked';?>> 육아
				<input type="checkbox" name="mb_5[]" value="산후조리"<?php if(strpos($member['mb_5'], "산후조리")!==false) echo ' checked';?>> 산후조리
				<input type="checkbox" name="mb_5[]" value="청소"<?php if(strpos($member['mb_5'], "청소")!==false) echo ' checked';?>> 청소
				<input type="checkbox" name="mb_5[]" value="식당"<?php if(strpos($member['mb_5'], "식당")!==false) echo ' checked';?>> 식당
				<input type="checkbox" name="mb_5[]" value="간병"<?php if(strpos($member['mb_5'], "간병")!==false) echo ' checked';?>> 간병
			</li>
			<li>
				<label>기타</label>
				<input type="checkbox" name="mb_5[]" value="제조, 생산"<?php if(strpos($member['mb_5'], "제조, 생산")!==false) echo ' checked';?>> 제조/생산
				<input type="checkbox" name="mb_5[]" value="물류"<?php if(strpos($member['mb_5'], "물류")!==false) echo ' checked';?>> 물류
				<input type="checkbox" name="mb_5[]" value="경비"<?php if(strpos($member['mb_5'], "경비")!==false) echo ' checked';?>> 경비
				<input type="checkbox" name="mb_5[]" value="운전"<?php if(strpos($member['mb_5'], "운전")!==false) echo ' checked';?>> 운전
				<input type="checkbox" name="mb_5[]" value="기타"<?php if(strpos($member['mb_5'], "기타")!==false) echo ' checked';?>> 기타
			</li>
			<li>
				<label>경력기간</label>
				<select name="mb_9">
					<option value="0년"<?php if($member['mb_9']==='0년'){echo ' selected="selected"';}?>>0년</option>
					<option value="1년"<?php if($member['mb_9']==='1년'){echo ' selected="selected"';}?>>1년</option>
					<option value="2년"<?php if($member['mb_9']==='2년'){echo ' selected="selected"';}?>>2년</option>
					<option value="3년"<?php if($member['mb_9']==="3년"){echo ' selected="selected"';}?>>3년</option>
					<option value="4년"<?php if($member['mb_9']==='4년'){echo ' selected="selected"';}?>>4년</option>
					<option value="5년"<?php if($member['mb_9']==='5년'){echo ' selected="selected"';}?>>5년</option>
					<option value="6년"<?php if($member['mb_9']==='6년'){echo ' selected="selected"';}?>>6년</option>
					<option value="7년"<?php if($member['mb_9']==='7년'){echo ' selected="selected"';}?>>7년</option>
					<option value="8년"<?php if($member['mb_9']==='8년'){echo ' selected="selected"';}?>>8년</option>
					<option value="9년"<?php if($member['mb_9']==='9년'){echo ' selected="selected"';}?>>9년</option>
					<option value="10년 이상"<?php if($member['mb_9']==='10년 이상'){echo ' selected="selected"';}?>>10년 이상</option>
				</select>
			</li>
        </ul>
	</div>

    <!-- 관련 이수증 -->
	<div class="form_01">
	    <h2>관련 이수증</h2>
	    <ul>
		    <?php
            // 첨부파일 경로
			$mb_1_path = G5_DATA_PATH.'/member/'.$member['mb_id'].'/'.$member['mb_1'];
    		$mb_1_url  = G5_DATA_URL.'/member/'.$member['mb_id'].'/'.$member['mb_1'];
			?>
            <li>
                <div>
	            <label for="reg_mb_1" class="frm_label">
	              	기초안전교육
                <input type="file" name="mb_1" id="reg_mb_1" style="float:right;">
                </div>
			    <!-- 파일선택 꾸미기 -->
					<!-- <span class="fileName"></span>
					<label for="reg_mb_1" class="btn_file">등록</label>
	                <input type="file" name="mb_1" id="reg_mb_1" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0  "> -->
                <span class="frm_info" style="font-size:0.9em"> <i class="far fa-question-circle" aria-hidden="true"></i> 이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
                 <?php if ($w == 'u' && file_exists($mb_1_path)) {  ?>
	                <img src="<?php echo $mb_1_url ?>" alt="기초안전교육">
	                <input type="checkbox" name="del_mb_1" value="1" id="del_mb_1">
	                <label for="del_mb_1" class="inline">삭제</label>
	            <?php }  ?>
	        </li>

                <?php
                // 첨부파일 경로
				$mb_2_path = G5_DATA_PATH.'/member/'.$member['mb_id'].'/'.$member['mb_2'];
    			$mb_2_url  = G5_DATA_URL.'/member/'.$member['mb_id'].'/'.$member['mb_2'];
				?>
                <li>
                    <div>
	                <label for="reg_mb_2" class="frm_label">
	                	보건증
	                	<input type="file" name="mb_2" id="reg_mb_2" style="float:right;">
	                </div>
					<span class="frm_info" style="font-size:0.9em"> <i class="far fa-question-circle" aria-hidden="true"></i> 이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
					<!-- 파일선택 꾸미기 -->
					<!-- <span class="fileName"></span>
					<label for="reg_mb_2" class="btn_file">등록</label>
	                <input type="file" name="mb_2" id="reg_mb_2" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0  "> -->

	                <?php if ($w == 'u' && file_exists($mb_2_path)) {  ?>
	                <img src="<?php echo $mb_2_url ?>" alt="보건증">
	                <input type="checkbox" name="del_mb_2" value="1" id="del_mb_2">
	                <label for="del_mb_2" class="inline">삭제</label>
	                <?php }  ?>
	            </li>

				<?php
                // 첨부파일 경로
				$mb_3_path = G5_DATA_PATH.'/member/'.$member['mb_id'].'/'.$member['mb_3'];
    			$mb_3_url  = G5_DATA_URL.'/member/'.$member['mb_id'].'/'.$member['mb_3'];
				?>
                <li>
                    <div>
	                <label for="reg_mb_3" class="frm_label">
	                	신분증 앞면
	                	<input type="file" name="mb_3" id="reg_mb_3" style="float:right;">
	                </div>
					
					<!-- 파일선택 꾸미기 -->
					<!-- <span class="fileName"></span>
					<label for="reg_mb_3" class="btn_file">등록</label>
	                <input type="file" name="mb_3" id="reg_mb_3" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0  "> -->
                    <span class="frm_info" style="font-size:0.9em"> <i class="far fa-question-circle" aria-hidden="true"></i> 이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>

	                

	                <?php if ($w == 'u' && file_exists($mb_3_path)) {  ?>
	                <img src="<?php echo $mb_3_url ?>" alt="신분증앞면">
	                <input type="checkbox" name="del_mb_3" value="1" id="del_mb_3">
	                <label for="del_mb_3" class="inline">삭제</label>
	                <?php }  ?>
	            </li>



				<?php
				// 첨부파일 경로
				$mb_4_path = G5_DATA_PATH.'/member/'.$member['mb_id'].'/'.$member['mb_4'];
    			$mb_4_url  = G5_DATA_URL.'/member/'.$member['mb_id'].'/'.$member['mb_4'];
				?>
                <li>
                    <div>
	                <label for="reg_mb_4" class="frm_label">
	                	신분증 뒷면
	                	<input type="file" name="mb_4" id="reg_mb_4" style="float:right;">
	                </div>
					
					<!-- 파일선택 꾸미기 -->
					<!-- <span class="fileName"></span>
					<label for="reg_mb_4" class="btn_file">등록</label>
	                <input type="file" name="mb_4" id="reg_mb_4" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0  "> -->

                    <span class="frm_info" style="font-size:0.9em"> <i class="far fa-question-circle" aria-hidden="true"></i> 이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
	                

	                <?php if ($w == 'u' && file_exists($mb_4_path)) {  ?>
	                <img src="<?php echo $mb_4_url ?>" alt="신분증뒷면">
	                <input type="checkbox" name="del_mb_4" value="1" id="del_mb_4">
	                <label for="del_mb_4" class="inline">삭제</label>
	                <?php }  ?>
	            </li>
        </ul>
	</div>
	<?php } ?>
    
    <div class="form_01">
        <h2>연락처 (선택)</h2>
        <ul>
	        <?php if ($config['cf_use_homepage']) { ?>
	        <li>
	            <label for="reg_mb_homepage" class="sound_only">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong>필수</strong><?php } ?></label>
	            <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" maxlength="255" <?php echo $config['cf_req_homepage']?"required":""; ?> placeholder="홈페이지">
	        </li>
	        <?php } ?>
	
	        <?php if ($config['cf_use_tel']) { ?>
	        <li>
	            <label for="reg_mb_tel" class="sound_only">전화번호<?php if ($config['cf_req_tel']) { ?><strong>필수</strong><?php } ?></label>
	            <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" class="frm_input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" <?php echo $config['cf_req_tel']?"required":""; ?> placeholder="전화번호">
	        </li>
	        <?php } ?>
	
	        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
	        <li>
	            <label for="reg_mb_hp" class="sound_only">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong>필수</strong><?php } ?></label>
	            
	            <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="휴대폰번호">
	            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	            <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	            <?php } ?>
	            
	        </li>
	        <?php } ?>
	
	        <?php if ($config['cf_use_addr']) { ?>
	        <li>
	        	<div class="adress">
	            	<span class="frm_label sound_only">주소<?php if ($config['cf_req_addr']) { ?>필수<?php } ?></span>
	            	<label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	            	<input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder="우편번호">
	            	<button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button><br>
	            </div>
	            <label for="reg_mb_addr1" class="sound_only">주소<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	            <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="주소"><br>
	            <label for="reg_mb_addr2" class="sound_only">상세주소</label>
	            <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address" size="50" placeholder="상세주소">
	            <br>
	            <label for="reg_mb_addr3" class="sound_only">참고항목</label>
	            <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address" size="50" readonly="readonly" placeholder="참고항목">
	            <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
	            
	        </li>
	        <?php } ?>
        </ul>
    </div>

    <div class="form_01">  
        <h2>기타 개인설정</h2>
		<ul>
			<?php if ($config['cf_use_signature']) { ?>
	        <li>
	            <label for="reg_mb_signature" class="sound_only">서명<?php if ($config['cf_req_signature']){ ?><strong>필수</strong><?php } ?></label>
	            <textarea name="mb_signature" id="reg_mb_signature" class="<?php echo $config['cf_req_signature']?"required":""; ?>" <?php echo $config['cf_req_signature']?"required":""; ?> placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
	        </li>
	        <?php } ?>
	
	        <?php if ($config['cf_use_profile']) { ?>
	        <li>
	            <label for="reg_mb_profile" class="sound_only">자기소개</label>
	            <textarea name="mb_profile" id="reg_mb_profile" class="<?php echo $config['cf_req_profile']?"required":""; ?>" <?php echo $config['cf_req_profile']?"required":""; ?> placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
	        </li>
	        <?php } ?>

	        

	        <li class="chk_box">
	        	<input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?> class="selec_chk">
	            <label for="reg_mb_mailling">
	            	<span></span>
	            	<b class="sound_only">메일링서비스</b>
	            </label>
	            <span class="chk_li">정보 메일을 받겠습니다.</span>
	        </li>

	        <?php if ($config['cf_use_hp']) { ?>
	        <li class="chk_box">
	            <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?> class="selec_chk">
	        	<label for="reg_mb_sms">
	            	<span></span>
	            	<b class="sound_only">SMS 수신여부</b>
	            </label>        
	            <span class="chk_li">휴대폰 문자메세지를 받겠습니다.</span>
	        </li>
	        <?php } ?>

	        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
	        <li class="chk_box">
	            <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> class="selec_chk">
	      		<label for="reg_mb_open">
	      			<span></span>
	      			<b class="sound_only">정보공개</b>
	      		</label>      
	            <span class="chk_li">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
	            <span class="frm_info">
                <i class="far fa-question-circle" aria-hidden="true"></i> 정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
	            </span>
	            <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>"> 
	        </li>
	        <?php } else { ?>
	        <li>
	            <span  class="frm_label">정보공개</span>
	            <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
	            
	            <span class="frm_info">
	                정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
	                이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
	            </span>
	        </li>
	        <?php } ?>

	        <?php
	        //회원정보 수정인 경우 소셜 계정 출력
	        if( $w == 'u' && function_exists('social_member_provider_manage') ){
	            social_member_provider_manage();
	        }
	        ?>
	
	        <?php if ($w == "" && $config['cf_use_recommend']) { ?>
	        <li>
	            <label for="reg_mb_recommend" class="sound_only">추천인아이디</label>
	            <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input full_input" placeholder="추천인아이디">
	        </li>
	        <?php } ?>

	        <li class="is_captcha_use">
	            <span  class="frm_label">자동등록방지</span>
	            <?php echo captcha_html(); ?>
	        </li>
	    </ul>
    </div>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL; ?>/" class="btn_cancel">취소</a>
        <button type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
    </div>
    </form>

    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function(e) {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url, e);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function(e) {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>", e);
            return;
        });
        <?php } ?>
    });

    // 인증체크
    function cert_confirm()
    {
        var val = document.fregisterform.cert_type.value;
        var type;

        switch(val) {
            case "ipin":
                type = "아이핀";
                break;
            case "hp":
                type = "휴대폰";
                break;
            default:
                return true;
        }

        if(confirm("이미 "+type+"으로 본인확인을 완료하셨습니다.\n\n이전 인증을 취소하고 다시 인증하시겠습니까?"))
            return true;
        else
            return false;
    }

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == '') {
            if (f.mb_password.value.length < 3) {
                alert('비밀번호를 3글자 이상 입력하십시오.');
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert('비밀번호가 같지 않습니다.');
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert('비밀번호를 3글자 이상 입력하십시오.');
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=='') {
            if (f.mb_name.value.length < 1) {
                alert('이름을 입력하십시오.');
                f.mb_name.focus();
                return false;
            }
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원아이콘이 이미지 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof f.mb_img != "undefined") {
            if (f.mb_img.value) {
                if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원이미지가 이미지 파일이 아닙니다.");
                    f.mb_img.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != 'undefined' && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert('본인을 추천할 수 없습니다.');
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js(); ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

	var uploadFile = $('.filebox .uploadBtn');
	uploadFile.on('change', function(){
		if(window.FileReader){
			var filename = $(this)[0].files[0].name;
		} else {
			var filename = $(this).val().split('/').pop().split('\\').pop();
		}
		$(this).siblings('.fileName').val(filename);
	});
    </script>
</div>