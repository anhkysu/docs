<?php

namespace App\Constants;


class ProjectManagement
{
  const TYPE_INFO_PROJECT_INFO = 'thong-tin-du-an';
  const TYPE_INFO_JOINT_STAFF = 'thanh-vien';
  const TYPE_INFO_IO_DATA = 'io-data';
  const TYPE_INFO_QUOTATION_TIME = 'thoi-gian-bao-gia';
  const TYPE_INFO_TECHNICAL_ERROR = 'loi-ky-thuat';
  const TYPE_INFO_WORKING_TIME = 'cong-viec-thuc-hien';
  const ORGANIZATION_INDIVIDUAL = 'individual';
  const ORGANIZATION_TEAM = 'team';
  const ORGANIZATION_DEPARTMENT = 'department';
  const ORGANIZATION_COMPANY = 'company';
  const DEFAULT_VALUE_OF_TABLE_WORKING_TIME_COLUMN_CONFIRM = 'Not Yet';
  const IO_STAFF_DATA_STATUS_NOT_FINISHED_ID = 10;
  const IO_STAFF_DATA_STATUS_IN_PROGRESS_ID = 11;
  const IO_STAFF_DATA_STATUS_FINISHED_ID = 12;
}
