<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$is_worker = $is_constructor = false;
if ($is_member) {
    // 근로자면
    if ($member['mb_10'] === 'worker')
        $is_worker = true;

    // 건설사면
    else if ($member['mb_10'] === 'constructor')
        $is_constructor = true;
}
// 스크랩 개수 표시
$sql = " select count(*) as cnt from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' ";
$row = sql_fetch($sql);
$scrap_cnt = $row['cnt'];

// 지원 내역 개수 표시
$sql = " select count(*) as cnt from {$g5['apply_table']} where mb_id = '{$member['mb_id']}' ";
$row = sql_fetch($sql);
$apply_cnt = $row['cnt'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<section id="ol_after" class="ol">
    <header id="ol_after_hd">
        <h2>나의 회원정보</h2>
        <span class="profile_img">
            <?php echo get_member_profile_img($member['mb_id']); ?>
            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" title="정보수정"><i class="fa fa-cog" aria-hidden="true"></i><span class="sound_only">정보수정</span></a>
        </span>
        <div class="ol_m_info">
        	<strong><?php echo $nick ?>님</strong>
        	<a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout" class="btn_b04">로그아웃</a>
        	<?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_ADMIN_URL ?>" class="btn_admin btn_04">관리자</a><?php }  ?>
    	</div>
    </header>
    <ul id="ol_after_private">
        <li>
            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" id="ol_after_memo" class="win_memo">
				<span class="sound_only">안 읽은 </span>쪽지<br>
                <strong><?php echo $memo_not_read ?></strong>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" id="ol_after_pt" class="win_point">포인트<br>
				<strong><?php echo $point ?></strong>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" id="ol_after_scrap" class="win_scrap">스크랩<br>
            	<strong class="scrap"><?php echo $scrap_cnt ?></strong>
            </a>
        </li>
        <?php 
        if($is_worker){ ?>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/apply.php" target="_blank" id="ol_after_apply" class="win_apply">지원 내역<br>
            	<strong class="apply"><?php echo $apply_cnt ?></strong>
            </a>
        </li>
        <?php } ?>
    </ul>

</section>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
