<?php
//echo "<pre>";print_r(readFileData());die;

requestController($_POST);

function requestController($data)
{
    if ($data['name'] && $data['surname'] && $data['email'] && $data['password'] && $data['rpassword']) {
        $errors = [];
        $users = readFileData();

        if ($data['password'] != $data['rpassword']) {
            $errors[] = "Password mismatch";
        }
        if (!strpos($data['email'], "@")) {
            $errors[] = "Email Incorrect";
        }
        if (in_array($data['email'], array_column($users, 'email'))) {
            $errors[] = 'Email is already exists';
        }

        if ($errors) {
            $errors_str = implode(',', $errors);
            log_write("Unsuccessful creation attempt with errors [" . $errors_str . ']');

            echo json_encode([
                'success' => false,
                'msg' => $errors,
            ]);die;
        } else {
            //add new user to array
            $users[] = [
                'id' => count($users),
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'password' => $data['password']
            ];

            //write new user to txt file
            writeFileData($users);
            log_write('Successfully login with email ' . $data['email']);

            echo json_encode([
                'success' => true,
                'msg' => "You are successfully authorize!",
            ]);die;
        }
    } else {
        echo json_encode([
            'success' => false,
            'msg' => ["Fill in all fields"],
        ]);die;
    }
}

//write logs
function log_write($msg)
{
    $file = fopen("logs.txt", "a");
    fwrite($file, date('Y-m-d H:i:s') . ' - ' . $msg . "\n");
    fclose($file);
}

//read serialize data from txt file to array
function readFileData()
{
    $file = 'users.txt';
    if (file_exists($file)) {
        $data = unserialize(file_get_contents($file));
    }

    //if data 'false' replace with empty array []
    return $data ? $data : [];
}

//write data to txt file
function writeFileData($data)
{
    $file = fopen("users.txt", "w");
    fwrite($file, serialize($data));
    fclose($file);
}