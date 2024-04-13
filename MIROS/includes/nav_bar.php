<?php //nav_bar.php

if (session_status() == PHP_SESSION_NONE) {
session_start();
}

function return_Nav_Array(){
    $role = [
        'research officer' => [//Research Officer
            'Dashboard'       =>'officer_dashboard.php',
            'Submit research' =>'create_submission.php'
        ],
        'supervisor' => [//Supervisor
            'Dashboard'         =>'management_dashboard.php',
            'Published research'=>'management_dashboard.php',
            'Preformance'       =>'officers_overview.php'
        ],
        'top manager' => [//Top Manager
            'Dashboard'         =>'management_dashboard.php',
            'Published Research'=>'research.php',
            'Preformance'       =>'officers_overview.php'
        ],
        'admin' => [//Admin
            'Dashboard'         =>'admin_dashboard.php',
            'All users'         =>'all_users.php',
            'Assign'            =>'assign_roles.php',
            'Shutdown'          =>'admin_shutdown.php'
        ]
    ];
    return array_merge(
        ['Home' => 'index.php', 'Profile' => 'profile.php'],
        [strtolower($_SESSION["role"])=>$role[ strtolower($_SESSION["role"]) ]],
        ['Log out' => 'logout.php']
    );
};

function notLoggedIn(){
    return [
        'Create Account'=>'register_user.php',
        'Contact'       =>'contact_guest.php',
        'Login'         =>'login.php'
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getNav') {
    header('Content-Type: application/json');
    if (isset($_SESSION["role"])){
        print(json_encode(
                ['role' => strtolower($_SESSION["role"]),
                'links'=>return_Nav_Array()
                ]
            )
        );
    } else {
        print(json_encode(
            ['role' => 'logged out',
            'links'=> notLoggedIn()
            ]
        ));
    }
    exit;
}