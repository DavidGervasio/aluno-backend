<?php
// Bucket Name
function config(){
    $bucket=getenv("AWS_BUCKET");
    if (!class_exists('S3'))require_once('S3.php');
                
    //AWS access info
    if (!defined('awsAccessKey')) define('awsAccessKey', getenv("AWS_ACCESS_KEY_ID"));
    if (!defined('awsSecretKey')) define('awsSecretKey', getenv("AWS_SECRET_ACCESS_KEY"));
                
    //instantiate the class
    $s3 = new S3(awsAccessKey, awsSecretKey);

    $s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

    $configDatas['s3'] = $s3;
    $configDatas['bucket'] = $bucket;
   
    return  $configDatas;
}
?>