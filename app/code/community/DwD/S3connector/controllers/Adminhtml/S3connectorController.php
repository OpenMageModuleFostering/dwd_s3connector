<?php

/**
 *
 * DwD-S3connector - Magento Extension
 *
 * @copyright Copyright (c) 2014 DwDesigner Inc. (http://www.dwdeveloper.com/)
 * @author Damian A. Pastorini - damian.pastorini@dwdeveloper.com
 *
 */

require(Mage::getBaseDir('lib').'/Aws/aws-autoloader.php');

class DwD_S3connector_Adminhtml_S3connectorController extends Mage_Adminhtml_Controller_Action
{
	
	public function importAction()
	{
		try {
			$s3Client = $this->getS3Client();
			$configuredFolder = Mage::getStoreConfig('dwd_s3connector/general/folder');
			$folderPathParts = explode('/', $configuredFolder);
			$folderFullPath = Mage::getBaseDir().'/';
			foreach($folderPathParts as $f) {
				if(!is_dir($folderFullPath.$f)) {
					mkdir($folderFullPath.$f);
				}
				$folderFullPath .= $f.'/';
			}
			$bucket = Mage::getStoreConfig('dwd_s3connector/general/bucket');
			$result = $s3Client->downloadBucket($folderFullPath, $bucket, null, array('allow_resumable'=>true));
			$this->_getSession()->addSuccess('The bucket '.$bucket.' was downloaded to '.$configuredFolder);
		} catch (Exception $e) {
			$this->_getSession()->addError('There was an error: '.$e->getMessage());
		}
		$this->_redirectReferer();
	}

	protected function getAwsClient()
	{
		$key = Mage::getStoreConfig('dwd_s3connector/general/aws_key');
		$secret = Mage::getStoreConfig('dwd_s3connector/general/aws_secret');
		$credentials = new \Aws\Common\Credentials\Credentials($key, $secret);
		$config = array('credentials' => $credentials);
		$awsClient = \Aws\Common\Aws::factory($config);
		return $awsClient;
	}

	protected function getS3Client()
	{
		$awsClient = $this->getAwsClient();
		$s3Client = $awsClient->get('S3');
		return $s3Client;
	}

}
