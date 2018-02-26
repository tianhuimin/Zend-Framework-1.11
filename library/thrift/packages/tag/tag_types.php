<?php
/**
 * Autogenerated by Thrift Compiler (0.8.0)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
include_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';


class thrift_UserExtendInfo {
  static $_TSPEC;

  public $userId = null;
  public $nickName = null;
  public $point = null;
  public $grade = null;
  public $vipPoint = null;
  public $vipGrade = null;
  public $realDesc = null;
  public $sexual = null;
  public $tag = null;
  public $age = null;
  public $birth = null;
  public $city = null;
  public $mobileType = null;
  public $photo = null;
  public $note = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'userId',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'nickName',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'point',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'grade',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'vipPoint',
          'type' => TType::I32,
          ),
        6 => array(
          'var' => 'vipGrade',
          'type' => TType::I32,
          ),
        7 => array(
          'var' => 'realDesc',
          'type' => TType::STRING,
          ),
        8 => array(
          'var' => 'sexual',
          'type' => TType::I32,
          ),
        9 => array(
          'var' => 'tag',
          'type' => TType::STRING,
          ),
        10 => array(
          'var' => 'age',
          'type' => TType::I32,
          ),
        11 => array(
          'var' => 'birth',
          'type' => TType::STRING,
          ),
        12 => array(
          'var' => 'city',
          'type' => TType::STRING,
          ),
        13 => array(
          'var' => 'mobileType',
          'type' => TType::I32,
          ),
        14 => array(
          'var' => 'photo',
          'type' => TType::STRING,
          ),
        15 => array(
          'var' => 'note',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['userId'])) {
        $this->userId = $vals['userId'];
      }
      if (isset($vals['nickName'])) {
        $this->nickName = $vals['nickName'];
      }
      if (isset($vals['point'])) {
        $this->point = $vals['point'];
      }
      if (isset($vals['grade'])) {
        $this->grade = $vals['grade'];
      }
      if (isset($vals['vipPoint'])) {
        $this->vipPoint = $vals['vipPoint'];
      }
      if (isset($vals['vipGrade'])) {
        $this->vipGrade = $vals['vipGrade'];
      }
      if (isset($vals['realDesc'])) {
        $this->realDesc = $vals['realDesc'];
      }
      if (isset($vals['sexual'])) {
        $this->sexual = $vals['sexual'];
      }
      if (isset($vals['tag'])) {
        $this->tag = $vals['tag'];
      }
      if (isset($vals['age'])) {
        $this->age = $vals['age'];
      }
      if (isset($vals['birth'])) {
        $this->birth = $vals['birth'];
      }
      if (isset($vals['city'])) {
        $this->city = $vals['city'];
      }
      if (isset($vals['mobileType'])) {
        $this->mobileType = $vals['mobileType'];
      }
      if (isset($vals['photo'])) {
        $this->photo = $vals['photo'];
      }
      if (isset($vals['note'])) {
        $this->note = $vals['note'];
      }
    }
  }

  public function getName() {
    return 'UserExtendInfo';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->userId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->nickName);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->point);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->grade);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->vipPoint);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->vipGrade);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 7:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->realDesc);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 8:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->sexual);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 9:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->tag);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 10:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->age);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 11:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->birth);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 12:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->city);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 13:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->mobileType);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 14:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->photo);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 15:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->note);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('UserExtendInfo');
    if ($this->userId !== null) {
      $xfer += $output->writeFieldBegin('userId', TType::I32, 1);
      $xfer += $output->writeI32($this->userId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->nickName !== null) {
      $xfer += $output->writeFieldBegin('nickName', TType::STRING, 2);
      $xfer += $output->writeString($this->nickName);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->point !== null) {
      $xfer += $output->writeFieldBegin('point', TType::I32, 3);
      $xfer += $output->writeI32($this->point);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->grade !== null) {
      $xfer += $output->writeFieldBegin('grade', TType::I32, 4);
      $xfer += $output->writeI32($this->grade);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->vipPoint !== null) {
      $xfer += $output->writeFieldBegin('vipPoint', TType::I32, 5);
      $xfer += $output->writeI32($this->vipPoint);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->vipGrade !== null) {
      $xfer += $output->writeFieldBegin('vipGrade', TType::I32, 6);
      $xfer += $output->writeI32($this->vipGrade);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->realDesc !== null) {
      $xfer += $output->writeFieldBegin('realDesc', TType::STRING, 7);
      $xfer += $output->writeString($this->realDesc);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->sexual !== null) {
      $xfer += $output->writeFieldBegin('sexual', TType::I32, 8);
      $xfer += $output->writeI32($this->sexual);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->tag !== null) {
      $xfer += $output->writeFieldBegin('tag', TType::STRING, 9);
      $xfer += $output->writeString($this->tag);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->age !== null) {
      $xfer += $output->writeFieldBegin('age', TType::I32, 10);
      $xfer += $output->writeI32($this->age);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->birth !== null) {
      $xfer += $output->writeFieldBegin('birth', TType::STRING, 11);
      $xfer += $output->writeString($this->birth);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->city !== null) {
      $xfer += $output->writeFieldBegin('city', TType::STRING, 12);
      $xfer += $output->writeString($this->city);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->mobileType !== null) {
      $xfer += $output->writeFieldBegin('mobileType', TType::I32, 13);
      $xfer += $output->writeI32($this->mobileType);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->photo !== null) {
      $xfer += $output->writeFieldBegin('photo', TType::STRING, 14);
      $xfer += $output->writeString($this->photo);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->note !== null) {
      $xfer += $output->writeFieldBegin('note', TType::STRING, 15);
      $xfer += $output->writeString($this->note);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class thrift_RecoFriendsList {
  static $_TSPEC;

  public $friendsNum = null;
  public $userList = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'friendsNum',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'userList',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => 'thrift_UserExtendInfo',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['friendsNum'])) {
        $this->friendsNum = $vals['friendsNum'];
      }
      if (isset($vals['userList'])) {
        $this->userList = $vals['userList'];
      }
    }
  }

  public function getName() {
    return 'RecoFriendsList';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->friendsNum);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::LST) {
            $this->userList = array();
            $_size0 = 0;
            $_etype3 = 0;
            $xfer += $input->readListBegin($_etype3, $_size0);
            for ($_i4 = 0; $_i4 < $_size0; ++$_i4)
            {
              $elem5 = null;
              $elem5 = new thrift_UserExtendInfo();
              $xfer += $elem5->read($input);
              $this->userList []= $elem5;
            }
            $xfer += $input->readListEnd();
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('RecoFriendsList');
    if ($this->friendsNum !== null) {
      $xfer += $output->writeFieldBegin('friendsNum', TType::I32, 1);
      $xfer += $output->writeI32($this->friendsNum);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->userList !== null) {
      if (!is_array($this->userList)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('userList', TType::LST, 2);
      {
        $output->writeListBegin(TType::STRUCT, count($this->userList));
        {
          foreach ($this->userList as $iter6)
          {
            $xfer += $iter6->write($output);
          }
        }
        $output->writeListEnd();
      }
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class thrift_SystemTag {
  static $_TSPEC;

  public $totalNum = null;
  public $systemTags = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'totalNum',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'systemTags',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['totalNum'])) {
        $this->totalNum = $vals['totalNum'];
      }
      if (isset($vals['systemTags'])) {
        $this->systemTags = $vals['systemTags'];
      }
    }
  }

  public function getName() {
    return 'SystemTag';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->totalNum);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->systemTags);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('SystemTag');
    if ($this->totalNum !== null) {
      $xfer += $output->writeFieldBegin('totalNum', TType::I32, 1);
      $xfer += $output->writeI32($this->totalNum);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->systemTags !== null) {
      $xfer += $output->writeFieldBegin('systemTags', TType::STRING, 2);
      $xfer += $output->writeString($this->systemTags);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

?>
