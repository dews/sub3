<?
//�ΨӦs���s�b��Ʈw���Ϥ��A�]���O�s�X�L��~�s�J���A�ҥH�n�ѽX�~��Ū�C�`�N�s�X�Aansi�C
include("../include/mysql_connect.inc.php");

//$SQLSTR="select filepic,filetype from test where filename='". $_REQUEST["filename"] . "'";
//test��Ʈw��
$SQLSTR="select photo, phototype from identity where photoname='". $_REQUEST["photoname"] . "'";
$cur=mysql_query($SQLSTR);
//���X���
$data=mysql_fetch_array( $cur );
//echo $data[1];
//���ո�Ʈ榡
header("Content-Type: $data[1]");
//�]�w������Ʈ榡
// ��X�Ϥ����
echo base64_decode($data[0]);
?>