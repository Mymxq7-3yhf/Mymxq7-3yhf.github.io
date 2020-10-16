<?php
namespace all;
require_once 'option.php';
use option\Operation;

        
class all
{
    
    use Operation;
    // 覆盖了父类的定义
    public $Person = array();
    
    public $index = 0;

    
}
    //new新对象
    $all = new all();// 犯了大错误
    do{
        
        echo "请选择需要办理的业务:";
        $option_nu  = fgets(STDIN);
        switch($option_nu){
            case 1:
                //打印对象里的函数
                $all->open();
                
                echo PHP_EOL;
                break;
            case 2:
                $all->query();
            
                break;
            case 3:
                $all->save();
                break; 
            case 4:
                $all->get_money();
                break; 
            case 5:
                $all->trans_money();
                break;            
            case 6:
                $all->change_pwd();
                break;              
            case 7:
                $all->lock();
                break;
            case 8:
                $all->unlock();
                break;
            case 9:
                $all->add();
                break;      
            default:
                echo "?";
                break;
        }


    // if($option_nu != 0){
    //     //new新对象
    //     $login = new login();
    //     //打印对象里的函数
    //     echo $login->view();  
    // }
    }while($option_nu != 0);

?>