<?php //nav_bar.php

if (session_status() == PHP_SESSION_NONE) {
session_start();
}

function return_Nav_Array(){
    $role = [
        'research officer' => [//Research Officer
            'Dashboard'       =>'officer_dashboard.php',
            'Submit research' =>'create_submission.php',
            'View Submissions'=>'officer_view_submissions.php',
            'Contact Admin'=>'contact_user.php',

        ],
        'supervisor' => [//Supervisor
            'Supervisor Team'=>'supervisor_team.php',
            'Awaiting Verification' => 'submission_overview.php',
            'View Submissions'         =>'supervisor_view_all.php',

            'Contact Admin'=>'contact_user.php',

        ],
        'top manager' => [//Top Manager
            'Dashboard'         =>'management_dashboard.php',
            'Submission Search'=>'search_for_all_submissions.php',
            'Assign  Supervisors' => 'manager_role-assign.php',
            'Assign Roles'            =>'assign_roles.php',
            'Contact Admin'=>'contact_user.php',

        ],
        'admin' => [//Admin
            'Dashboard'         =>'admin_dashboard.php',
            'Assign'            =>'assign_roles.php',
            'Shutdown'          =>'admin_shutdown.php',
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
?>

