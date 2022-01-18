<?php
    require_once "Database.php";

    $from_date = $_REQUEST["fromDate"];
    $to_date = $_REQUEST["toDate"];

    $db = new Database();
    $sql = "SELECT * FROM `lessor_payment` WHERE `date` BETWEEN :DATEFROM AND :DATETO";
    $stmt = $db->getConn()->prepare($sql);
    $stmt->bindValue(':DATEFROM' , $from_date);
    $stmt->bindValue(':DATETO', $to_date);
    $stmt->execute();
    $total_amt = null;
?>

    <table class="table table-striped fs-11" id="table">
        <thead class="table-light">
            <th>Payment Id</th>
            <th>Payer Email</th>
            <th>Bike</th>
            <th>Lessor Id</th>
            <th>User Id</th>
            <th>Total Amount</th>
            <th>Date</th>
        </thead>
        <tbody class="table-light">
            <?php
                while($row = $stmt->fetch()){
                
                $total_amt += $row["total_amt"];

            ?>
                <tr>
                    <td><?= $row["payment_id"]?></td>
                    <td><?= $row["Payer_Email"] ?></td>
                    <td><?= $row["bike_description"] ?></td>
                    <td><?= $row["lessor_id"] ?></td>
                    <td><?= $row["user_id"] ?></td>
                    <td><?= $row["total_amt"] ?></td>
                    <td><?= $row["date"]?></td>
                </tr>
            <?php
                }
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2">
                        <h4><span class="fs-14"> Total Sales: </span> <span class="text-danger fs-18 border border-dark p-1"> &nbsp; ₱ <?= number_format($total_amt,"2") ?></span></h4>
                    </td>
                </tr>
        </tbody>
    </table>

    
<?php
    $stmt->closeCursor();
?>