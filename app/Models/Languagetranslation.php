<?php namespace App\Models;

use App\Models\Crud;
use CodeIgniter\Model;


class Languagetranslation extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function AlterLangTranslations(){

        $FinalArray = array(); $Crud = new Crud();

        $Arabic = array(
            'visa_issued' => 'تم إصدار التأشيرة',
            'total_pax' => 'إجمالي عدد الأفراد',
            'stats' => 'احصائيات',
            'mofa_not_issued' => ' موفا غير صادرة',
            'mofa_issued' => 'موفا صدر',
            'external' => 'خارجي',
            'b2b' => 'B2B',
            'b2c' => 'B2C',
            'voucher_not_issued' => 'لم يتم إصدار القسيمة',
            'voucher_issued' => 'تم إصدار القسيمة',
            'arrival' => 'وصول',
            'check_in_medina' => 'تحقق في المدينة المنورة',
            'check_in_mecca' => 'تحقق في مكة',
            'check_in_jeddah' => 'تحقق في جدة',
            'exit' => 'مخرج'
        );
        ksort($Arabic);
        $FinalArray['ar'] = $Arabic;

        $English = array(
            'visa_issued' => 'Visa Issued',
            'total_pax' => 'Total Pax',
            'stats' => 'Stats',
            'mofa_not_issued' => 'Mofa Not Issued',
            'mofa_issued' => 'Mofa Issued',
            'external' => 'External',
            'b2b' => 'B2B',
            'b2c' => 'B2C',
            'voucher_not_issued' => 'Voucher Not Issued',
            'voucher_issued' => 'Voucher Issued',
            'arrival' => 'Arrival',
            'check_in_medina' => 'Check In Medina',
            'check_in_mecca' => 'Check In Mecca',
            'check_in_jeddah' => 'Check In Jeddah',
            'exit' => 'Exit'
        );
        ksort($English);
        $FinalArray['en'] = $English;

       foreach( $FinalArray as $languageCode => $Data ){

          $Crud->DeleteRecord('main."LanguageTranslations"', array('Code' => $languageCode));

           foreach( $Data as $Key => $Value ){
               $DataArray = array();
               $DataArray['Code'] = $languageCode;
               $DataArray['Key'] = trim($Key);
               $DataArray['Value'] = trim($Value);
               $Crud->AddRecord('main."LanguageTranslations"', $DataArray);
           }
       }
    }

    public
    function GetLanguageTranslationData($language = 'en'){

        $Crud = new Crud(); $FinalArray = array();

        $SQL = ' SELECT * FROM main."LanguageTranslations"
                  WHERE  main."LanguageTranslations"."Code" = \''.$language.'\' ';
        $record = $Crud->ExecuteSQL($SQL);
        if(count( $record ) > 0){
            foreach( $record as $r ){
                $FinalArray[$r['Key']] = $r['Value'];
            }
        }

        return $FinalArray;
    }

}
