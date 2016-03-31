<?php

function calculateClosingBalance() {
    $result_bal = mysqli_query($conn, "SELECT amount from cashstock where transaction_type='opening balance' and date='$date'");
    if (mysqli_num_rows($result_bal) > 0) {
        $row = mysqli_fetch_assoc($result_bal);
        $opbal_ = $row['amount'];
    } else {
        $opbal_ = 0.00;
    }
    $result_cashin = mysqli_query($conn, "SELECT sum(amount) as cashin from cashstock where amount > 0 and transaction_type !='opening balance' and date= '$date'");
    if (mysqli_num_rows($result_cashin) > 0) {
        $row = mysqli_fetch_assoc($result_cashin);
        if ($row['cashin']) {
            $cashin = $row['cashin'];
        } else {
            $cashin = 0.00;
        }
    } else {
        $cashin = 0.00;
    }
    $result_cashout = mysqli_query($conn, "SELECT sum(amount) as cashout from cashstock where amount < 0 and transaction_type != 'customer payment' and date= '$date' ");
    if (mysqli_num_rows($result_cashout) > 0) {
        $row = mysqli_fetch_assoc($result_cashout);
        if ($row['cashout']) {
            $cashout = $row['cashout'];
        } else {
            $cashout = 0.00;
        }
    } else {
        $cashout = 0.00;
    }
    $balance = $opbal_ + $cashin + $cashout;
    return $balance;
}