<?php

namespace App\Enum;

use ReflectionEnum;

enum Message : String
{
    case select     =   'select';
    case index      =   'index';
    case create     =   'create';
    case update     =   'update';
    case show       =   'show';
    case destroy    =   'destroy';
    case restore    =   'restore';
    case restoremany=   'restoreAll';
    case trashed    =   'trashed';
    case clean      =   'emptyTrash';
    case force      =   'forceDelete';
    case forcemany  =   'destroyMultiple';
 /**
     * [Will return cases name list]
     *
     * @return [array]
     * 
     */
    public static function getCases(){
        return array_column(self::cases(), 'name');
    }

   /**
     * [return cases list with description]
     *
     * @return [array]
     * 
     */
    public static function get(){
        foreach(array_column(self::cases(), 'name') as $item){
            $arr[$item]=self::getFromName($item)->description();
        }
        return $arr;
    }

     /**
     * [get case object by name]
     *
     * @return [type]
     * 
     */
    public static function getFromName($name){
        $reflection = new ReflectionEnum(self::class);
        return $reflection->getCase($name)->getValue();
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     * 
     */
    public function description(){
        return match($this){
            self::select=>['type'=>'plural',
            'message'=>'fatched for select',
            'logMessage'=>'fatched for select by',
            'exception'=>'fatch for select failed '
        ],
            self::index=>['type'=>'plural',
            'message'=>'list fetched',
            'logMessage'=>'list fetched by',
            'exception'=>'list fetch failed '
        ],
            self::create=>['type'=>'singular',
            'message'=>'created',
            'logMessage'=>'created by',
            'exception'=>'create failed '
        ],
            self::update=>['type'=>'singular',
            'message'=>'updated',
            'logMessage'=>'updated by',
            'exception'=>'update failed '
        ],
            self::show=>['type'=>'singular',
            'message'=>'fetch',
            'logMessage'=>'fetched by',
            'exception'=>'fetche failed '
        ],
            self::destroy=>['type'=>'singular',
            'message'=>'deleted',
            'logMessage'=>'deleted by',
            'exception'=>'delete failed '
        ],
            self::restore=>['type'=>'singular',
            'message'=>'restored',
            'logMessage'=>'restored by',
            'exception'=>'fatched for select failed '
        ],
            self::restoremany=>['type'=>'plural',
            'message'=>'restored',
            'logMessage'=>'restored by',
            'exception'=>'restore failed'
        ],
            self::trashed=>['type'=>'singular',
            'message'=>'moved to trash',
            'logMessage'=>'move to trash by',
            'exception'=>'move to trash failed'
        ],
            self::clean=>['type'=>'plural',
            'message'=>'trash cleaned',
            'logMessage'=>'trashed cleaned by',
            'exception'=>'trash clean failed'
        ],
            self::force=>['type'=>'singular',
            'message'=>'trash cleaned',
            'logMessage'=>'trashe cleaned by',
            'exception'=>'trash clean failed'
        ],
            self::forcemany=>['type'=>'plural',
            'message'=>'parmanently deleted',
            'logMessage'=>'parmanently deleted by',
            'exception'=>'parmanently delete failed,'
        ],
        };
    }

    public function toStraing(){
        return match($this){
            self::select     =>   "Select",
            self::index      =>   "Index",
            self::create     =>   "Create",
            self::update     =>   "Update",
            self::show       =>   "show",
            self::destroy    =>   "Destroy",
            self::restore    =>   "Restore",
            self::restoremany=>   "Restore many",
            self::trashed    =>   "Trashed",
            self::clean      =>   "Clean",
            self::force      =>   "Force Delete",
            self::forcemany  =>   "Force Destroy Many",
        };
    }
    
}