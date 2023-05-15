<?php

namespace gratistech;

//would be defined elsewhere in the framework
define('SITEURL', 'http://gratis.test');

/** 
 * todo:
 * - error handling
 * - 
**/

class gratis {
    private $config;

    private $dbcall;

    private $currentpage = 'listing';

    private $pages = ['list', 'details', 'login', 'processlogin', 'dashboard'];

    public function __construct()
    {
        $this->loadconfig();
        $this->loaddb();

        session_start();
    }

    public function generate()
    {
        call_user_func([$this, $this->currentpage]);
    }

    public function listing()
    {
        $data = $this->dbcall2('select * from cars');

        $this->display('listing', [$data]);
    }

    public function details()
    {
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $query = 'select * from cars inner join car_images on cars.id = car_images.cid where id=? order by car_images.iorder asc';
            $stmt = $this->dbcall->prepare($query);
            $stmt->bind_param('i', $_GET['id']);
            $stmt->execute();

            $result = $stmt->get_result();
            $cardata = $result->fetch_all(MYSQLI_ASSOC);

            if(count($cardata) > 0)
            {
                $detailsquery = 'select * from car_data where cid=?';
                $stmt2 = $this->dbcall->prepare($detailsquery);
                $stmt2->bind_param('i', $_GET['id']);
                $stmt2->execute();

                $detailsresult = $stmt2->get_result();
                $cardetails = $detailsresult->fetch_all(MYSQLI_ASSOC);
            }

            $this->display('details', [$cardata, $cardetails]);
        }
        else
        {
            header("Location: " .SITEURL);
        }
    }

    public function login()
    {
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
            header("location: " .SITEURL .'/?page=dashboard');
            exit;
        }
        else
        {
            $this->display('login');
        }
    }

    public function processlogin()
    {
        $username = $password = "";
        $username_err = $password_err = $login_err = "";
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
 
            if(empty(trim($_POST["email"])))
            {
                $email_err = "Please enter email.";
            }
            else
            {
                $email = trim($_POST["email"]);
            }
            
            if(empty(trim($_POST["password"])))
            {
                $password_err = "Please enter your password.";
            }
            else
            {
                $password = trim($_POST["password"]);
            }
            
            if(empty($email_err) && empty($password_err))
            {
                $sql = "SELECT uid, email, password FROM users WHERE email = ?";
                
                if($stmt = $this->dbcall->prepare($sql))
                {
                    $param_email = $email;
                    $stmt->bind_param("s", $param_email);
                    
                    if($stmt->execute())
                    {
                        $stmt->store_result();

                        if($stmt->num_rows == 1)
                        {
                            $stmt->bind_result($uid, $email, $hashed_password);
                            if($stmt->fetch()){echo 'here';
                                if(password_verify($password, $hashed_password))
                                {                            
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["uid"] = $uid;
                                    $_SESSION["email"] = $email;                            
                                    
                                    header("location: " .SITEURL .'/?page=dashboard');
                                } else
                                {
                                    $login_err = "Invalid email or password.";
                                }
                            }
                        } else{
                            $login_err = "Invalid email or password.";
                            $this->display('login', ['', '', $login_err]);
                        }
                    } else
                    {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    $stmt->close();
                }
            }
            else
            {
                $this->display('login', [$email_err, $password_err, $login_err]);
            }
        }
        else
        {
            $this->display('login');
        }
    }

    public function dashboard()
    {
        if(!$_SESSION['loggedin'])
        {
            header("Location: " .SITEURL);
        }

        $cars = $this->dbcall2('select * from cars');

        $this->display('dashboard', $cars);
    }

    public function setpage($page)
    {
        if(in_array($page, $this->pages))
        {
            $this->currentpage = $page;
        }
    }

    private function display($view, $params=false)
    {
        include_once('views/layout/header.php');
        include_once('views/' .$view .'.php');
        include_once('views/layout/footer.php');
    }

    private function dbcall2($query, $type='GET')
    {
        $query = $this->dbcall->query($query);

        if($query === false)
        {
            trigger_error('Invalid SQL: ' . $this->dbcall->error, E_USER_ERROR);
        }
        else
        {
            if($type == 'POST')
            {
                //write post
            }
            else
            {
                $rows_returned = $query->num_rows;
                $data_array = $query->fetch_all(MYSQLI_ASSOC);
    
                return ['count'=>$rows_returned, 'data'=>$data_array];
            }
        }
    }

    private function loadconfig()
    {
        include_once('inc/config.php');
        $this->config = $config;
    }

    private function loaddb()
    {
        $this->dbcall = new \mysqli($this->config['dbhost'], $this->config['dbuser'], $this->config['dbpass'], $this->config['dbname']);
    }
}

$gratis = new gratis();
if(isset($_GET['page']))
{
    $gratis->setpage($_GET['page']);
}

$gratis->generate();