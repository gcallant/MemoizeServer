<?php

function gravatar_url($email)
{
    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?" . http_build_query([
            's' => 60,
            'd' => 'https://st.depositphotos.com/1899467/2478/v/950/depositphotos_24789399-stock-illustration-blue-feather-pen.jpg'
        ]);
}
