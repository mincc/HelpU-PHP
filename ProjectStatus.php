<?php
require('AbstractEnum.php');

class ProjectStatus extends AbstractEnum
{

	public static $Create;
	public static $NewProject;
	public static $Match;
	public static $Pick;
	public static $SelectedNotification;
	public static $ConfirmRequest;
	public static $Quotation;
	public static $ConfirmQuotation;
	public static $Deal;
	public static $DealNotification;
	public static $ReceiveDownPayment;
	public static $ServiceStart;
	public static $ServiceDone;
	public static $CustomerRating;
	public static $ServiceProvRating;
	public static $ProjectClose;
	public static $RemoveFromView;
	public static $TotallyRemoved;
	public static $Reselect;
	public static $ConfirmRequestNotification;
	public static $QuotationNotification;
	public static $ConfirmQuotationNotification;
	public static $ServiceStartNotification;
	public static $ServiceDoneNotification;
	public static $CustomerRatingNotification;
	public static $ServiceProviderRatingNotification;	
	public static $PlanStartDate;
	public static $PlanStartDateNotification;


	public static function _init()
	{
		self::$Create = self::enum(0, 'New');
		self::$NewProject = self::enum(1, 'New');
		self::$Match = self::enum(2, 'Match');
		self::$Pick = self::enum(3, 'Pick');
		self::$SelectedNotification = self::enum(4, 'Selected Notification');
		self::$ConfirmRequest = self::enum(5, 'Confirm Request');
		self::$Quotation = self::enum(6, 'Quotation');
		self::$ConfirmQuotation = self::enum(7, 'Confirm Quotation');
		self::$Deal = self::enum(8, 'Deal');
		self::$DealNotification = self::enum(9, 'Deal Notification');
		self::$ReceiveDownPayment = self::enum(10, 'Receive Down Payment');
		self::$ServiceStart = self::enum(11, 'Service Start');
		self::$ServiceDone = self::enum(12, 'Service Done');
		self::$CustomerRating = self::enum(13, 'Customer Rating');
		self::$ServiceProvRating = self::enum(14, 'Service Provider Rating');
		self::$ProjectClose = self::enum(15, 'Project Close');
		self::$RemoveFromView = self::enum(16, 'Remove From View');
		self::$TotallyRemoved = self::enum(17, 'Totally Removed');
		self::$Reselect = self::enum(18, 'Reselect');
		self::$ConfirmRequestNotification = self::enum(19, 'Comfirm Request Notification');
		self::$QuotationNotification = self::enum(20, 'Quotation Notification');
		self::$ConfirmQuotationNotification = self::enum(21, 'Confirm Quotation Notification');
		self::$ServiceStartNotification = self::enum(22, 'Service Start Notification');
		self::$ServiceDoneNotification = self::enum(23, 'Service Done Notification');
		self::$CustomerRatingNotification = self::enum(24, 'Customer Rating Notification');
		self::$ServiceProviderRatingNotification = self::enum(25, 'Service Provider Rating Notification');
		self::$PlanStartDate = self::enum(26, 'Plan Start Date');
		self::$PlanStartDateNotification = self::enum(27, 'Plan Start Date Notification');
	}
}

ProjectStatus::_init();
?>