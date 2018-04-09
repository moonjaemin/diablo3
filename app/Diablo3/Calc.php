<?php

namespace App\Diablo3;

class Calc
{
    /*
    1=도끼, 2=단도, 3=철퇴, 4=창, 5=도검, 6=의식용칼, 7=주먹구기, 8=도리깨, 9=거대무기, 10=낫
    11=도끼, 12=철퇴, 13=미늘창, 14=지팡이, 15=도검, 16=대봉, 17=도리깨, 18=거대무기, 19= 낫
    20=활, 21=쇠뇌, 22=손쇠뇌, 23=마법봉
    */

    private $weaponInfo = array(
            '1'=>array('as'=>1.3,'baseMin'=>249,'baseMax'=>461,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '2'=>array('as'=>1.5,'baseMin'=>107,'baseMax'=>321,'normalMin'=>1049,'normalMax'=>1304,'ancientMin'=>1365,'ancientMax'=>1700),
            '3'=>array('as'=>1.2,'baseMin'=>316,'baseMax'=>585,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '4'=>array('as'=>1.2,'baseMin'=>353,'baseMax'=>526,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '5'=>array('as'=>1.4,'baseMin'=>168,'baseMax'=>392,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '6'=>array('as'=>1.4,'baseMin'=>117,'baseMax'=>469,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '7'=>array('as'=>1.4,'baseMin'=>168,'baseMax'=>392,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '8'=>array('as'=>1.4,'baseMin'=>192,'baseMax'=>355,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '9'=>array('as'=>1.3,'baseMin'=>249,'baseMax'=>461,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '10'=>array('as'=>1.3,'baseMin'=>249,'baseMax'=>461,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '11'=>array('as'=>1.1,'baseMin'=>1384,'baseMax'=>1685,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '12'=>array('as'=>1,'baseMin'=>1737,'baseMax'=>1912,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '13'=>array('as'=>1.05,'baseMin'=>1497,'baseMax'=>1823,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '14'=>array('as'=>1.1,'baseMin'=>1229,'baseMax'=>1839,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '15'=>array('as'=>1.15,'baseMin'=>1137,'baseMax'=>1702,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '16'=>array('as'=>1.15,'baseMin'=>994,'baseMax'=>1845,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '17'=>array('as'=>1.15,'baseMin'=>1351,'baseMax'=>1486,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '18'=>array('as'=>1.1,'baseMin'=>1462,'baseMax'=>1609,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '19'=>array('as'=>1.1,'baseMin'=>1461,'baseMax'=>1607,'normalMin'=>1439,'normalMax'=>1788,'ancientMin'=>1870,'ancientMax'=>2325),
            '20'=>array('as'=>1.4,'baseMin'=>143,'baseMax'=>815,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '21'=>array('as'=>1.1,'baseMin'=>779,'baseMax'=>945,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940),
            '22'=>array('as'=>1.6,'baseMin'=>126,'baseMax'=>714,'normalMin'=>1049,'normalMax'=>1304,'ancientMin'=>1365,'ancientMax'=>1700),
            '23'=>array('as'=>1.4,'baseMin'=>193,'baseMax'=>357,'normalMin'=>1199,'normalMax'=>1490,'ancientMin'=>1560,'ancientMax'=>1940)

    );

    public function __construct() {

    }

    public function weapon($data) {

        $weaponType = $data['weaponType'];
        $weapon = preg_replace('/\D/','',$data['weapon']);
        $damageMin = preg_replace('/\D/','',$data['damageMin']);
        $damageMax = preg_replace('/\D/','',$data['damageMax']);

        $damage = preg_replace('/\D/','',$data['damage']);
        $speed = preg_replace('/\D/','',$data['speed']);

        $return = array();
        $return['top'] = "baseDamage";

        $return['original'] = $this->weaponCalc($this->weaponInfo[$weapon]['as'],
                                                  $this->weaponInfo[$weapon]['baseMin'],
                                                  $this->weaponInfo[$weapon]['baseMax'],
                                                  $damageMin,
                                                  $damageMax,
                                                  $damage,
                                                  $speed);


        //공격력 변경
        $return['baseDamage'] = $this->weaponCalc($this->weaponInfo[$weapon]['as'],
                                                  $this->weaponInfo[$weapon]['baseMin'],
                                                  $this->weaponInfo[$weapon]['baseMax'],
                                                  $this->weaponInfo[$weapon][$weaponType.'Min'],
                                                  $this->weaponInfo[$weapon][$weaponType.'Max'],
                                                  $damage,
                                                  $speed);


        //피해 변경
        $return['damage'] = $this->weaponCalc($this->weaponInfo[$weapon]['as'],
                                              $this->weaponInfo[$weapon]['baseMin'],
                                              $this->weaponInfo[$weapon]['baseMax'],
                                              $damageMin,
                                              $damageMax,
                                              10,
                                              $speed);

        if($return['baseDamage'] < $return['damage']) {
            $return['top'] = "damage";
        }
        //공속변경
        $return['speed'] = $this->weaponCalc($this->weaponInfo[$weapon]['as'],
                                             $this->weaponInfo[$weapon]['baseMin'],
                                             $this->weaponInfo[$weapon]['baseMax'],
                                             $damageMin,
                                             $damageMax,
                                             $damage,
                                             7);

         if($return[$return['top']] < $return['speed']) {
             $return['top'] = "speed";
         }
        //최상급
        $return['best'] = $this->weaponCalc($this->weaponInfo[$weapon]['as'],
                                            $this->weaponInfo[$weapon]['baseMin'],
                                            $this->weaponInfo[$weapon]['baseMax'],
                                            $this->weaponInfo[$weapon][$weaponType.'Min'],
                                            $this->weaponInfo[$weapon][$weaponType.'Max'],
                                            10,
                                            7);
        return $return;
    }

    private function weaponCalc($as, $baseMin, $baseMax, $addMin, $addMax, $damage = 0, $speed = 0) {

        $a = ($baseMin + $baseMax) / 2;
        $b = ($addMin + $addMax) / 2;
        $c = $a + $b;
        $d = $damage / 100 + 1;
        $e = $as * ($speed / 100 + 1);
        $f = $c * $d * $e;
        return round(($f * 10) / 10,1);
    }

}
