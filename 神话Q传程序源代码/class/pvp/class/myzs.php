<?php
   
if (!defined('wapxyz')) {
	exit('Not Found WAPWORK,程序异常操作！');
}
//打怪中的普通攻击代码
$shuliang="0";
foreach($list as $ks=>$zd){


//只攻击这个对象
if($zd['duixiang']==$gongji_duixiang){

	$zhandou0= explode("|", $zd['name']); 
		if($zhandou0['0']=="user"){
			//人物对象
			$guaiwu = mysqli_query($db,"SELECT * FROM users WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}elseif($zhandou0['0']=="pet"){
	//宠物对象
	$guaiwu = mysqli_query($db,"SELECT * FROM pet WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}elseif($zhandou0['0']=="guaiwu"){
	//怪物对象
	$guaiwu = mysqli_query($db,"SELECT * FROM guaiwu WHERE id='".$zhandou0['1']."'");
$guaiwu = mysqli_fetch_array($guaiwu);
}


if($guaiwu[qixuemax]>"0"){
	$shuliang+="1";
	if($shuliang>$jineng_u['2']){
		break;//跳出循环
	}

//开始攻击
if($jineng_u[3]=="wu"){
$zhandou_gongji=$pkuser[gongji];
}else{
$zhandou_gongji=$pkuser[gongji_fa];
}
//获取技能是法术还是物理
for ($c=0;$c<$jineng_u['0'];$c++) 
{
if($zhandou_gongji>'0'||$pkuser[pojia]>"0" ||$jineng_u['10']>'0'){
	//有伤害
	
$zhandou_shanghai=$zhandou_gongji;
if($zhandou_shanghai<"1"){
	$zhandou_shanghai="0";
}

$zhandou_shanghai+=$jineng_u['10'];
$zhandou_shanghai*=$jineng_u['9'];
$zhandou_shanghai+=$pkuser[pojia];//破甲
$mianshang=100-$guaiwu[mianshang];
$mianshang/=100;
$zhandou_shanghai*=$mianshang;
if($zhandou_shanghai<"1"){
	$zhandou_shanghai="1";
}
$pojia_text=null;
if($pkuser[pojia]>"0"){
    $pkuser_pojia=$pkuser[pojia]*$mianshang;
    $pojia_text="(+".$pkuser_pojia."破甲)";
}


$guaiwu[qixuemax]-=$zhandou_shanghai;
	$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."对".$guaiwu[username]."使用了".$jineng_u[5]."减少".$zhandou_shanghai.$pojia_text."点最大生命值！','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}else{
	//无伤害
		$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."对".$guaiwu[username]."使用了".$jineng_u[5]."造成0点伤害','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
$zhandou_shanghai="0";
}
//boss伤害获取经验
if($guaiwu[boss]=="yes"){
	$zhandou_jingyan=$zhandou_shanghai*0.3;
	$zhandou_jingyan=floor($zhandou_jingyan);
	$pkuser[jingyan]+=$zhandou_jingyan;
}
}

//判断是否死了
if($guaiwu[qixue]<"1"){
		$s0="insert into pvp_tip(text,cid,time) values('".$guaiwu[username]."被打死了','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}

//数据写入数据库
if($guaiwu[boss]=="yes"){
	if($zhadou_yuanshi['0']=="user"){
			//人物对象
$sql1="update users set jingyan='".$pkuser[jingyan]."' where id='".$pkuser[id]."'";
$ok=mysqli_query($db,$sql1);
	$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."获得".$zhandou_jingyan."点经验！','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}elseif($zhadou_yuanshi['0']=="pet"){
	//宠物对象	
$sql1="update pet set jingyan='".$pkuser[jingyan]."' where id='".$pkuser[id]."'";
$ok=mysqli_query($db,$sql1);
	$s0="insert into pvp_tip(text,cid,time) values('".$pkuser[username]."获得".$zhandou_jingyan."点经验！','".$pk[id]."','".time()."')";
$ok0=mysqli_query($db,$s0);
}
}

//怪物数据
if($zhandou0['0']=="user"){
			//人物对象
$sql1="update users set qixuemax='".$guaiwu[qixuemax]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}elseif($zhandou0['0']=="pet"){
	//宠物对象	
$sql1="update pet set qixuemax='".$guaiwu[qixuemax]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}elseif($zhandou0['0']=="guaiwu"){
	//怪物对象	
$sql1="update guaiwu set qixuemax='".$guaiwu[qixuemax]."' where id='".$zhandou0['1']."'";
$ok=mysqli_query($db,$sql1);

}
//获取敌方对象结束
}




}}