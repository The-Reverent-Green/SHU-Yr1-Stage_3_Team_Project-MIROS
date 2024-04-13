<?php //nav_bar.php

if (session_status() == PHP_SESSION_NONE) {
session_start();
}

function return_Nav_Array(){
    [
    'R_Dashboard'       =>'officer_dashboard.php',
    'R_Submit research'   =>'create_submission.php',
    
    'S_Dashboard'       =>'management_dashboard.php',
    'S_Published research'=>'management_dashboard.php',
    'S_Preformance'       =>'officers_overview.php',
    
    'M_Dashboard'         =>'management_dashboard.php',
    'M_Published Research'=>'research.php',
    'M_Preformance'       =>'officers_overview.php',
        
    'A_Dashboard'         =>'admin_dashboard.php',
    'A_All users'         =>'all_users.php',
    'A_Assign'            =>'assign_roles.php',
    'A_Shutdown'          =>'admin_shutdown.php',
    
    
    
    'Create Submission'=>'create_submission.php',
    'Delete Submission'=>'delete_submission.php',
    'View Submissions'=>'officer_view_submissions.php',
];
    $role = [
        'research officer' => [//Research Officer
            'Dashboard'       =>'officer_dashboard.php',
            'Submit research' =>'create_submission.php',
            'View Submissions'=>'officer_view_submissions.php',
            'Contact User'=>'contact_user.php',

        ],
        'supervisor' => [//Supervisor
            'Dashboard'         =>'supervisor_dashboard.php',
            'Supervisor Team'=>'supervisor_team.php',
            'Awaiting Verification' => 'submission_overview.php',
            'Contact User'=>'contact_user.php',

        ],
        'top manager' => [//Top Manager
            'Dashboard'         =>'management_dashboard.php',
            'Submission Search'=>'research.php',
            'Assign'            =>'assign_roles.php',
            'Contact User'=>'contact_user.php',

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

