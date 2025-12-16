<?php
global $SITE_SERVER_NAME;
global $SITE_DIR;
$phone = file_get_contents($_SERVER["DOCUMENT_ROOT"] . $SITE_DIR . 'include/header_phone.php');
$email = file_get_contents($_SERVER["DOCUMENT_ROOT"] . $SITE_DIR . 'include/header_mail.php');
?>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
    <td>
        <table width="700" cellpadding="0" cellspacing="0">
            <tbody>
            <tr style="background-color: #4c5256; color:#fff;">
                <td style="padding: 20px;">
                    <? if ($phone != ''): ?>
                        <br>
                        <strong><?=GetMessage("ARLIGHT_ARSTORE_TELEFON")?></strong> <a href="tel:<?= $phone ?>" target="_blank"
                                                     style=" color:#fff;"><?= $phone ?></a> <br>
                    <? endif; ?>
                    <? if ($email != ''): ?>
                        <br>
                        <strong>E-mail:</strong> <a href="mailto:<?= $email ?>" target="_blank"
                                                    style=" color:#fff;"><?= $email ?></a>
                    <? endif; ?>
                    <br><br>
                    <strong><?=GetMessage("ARLIGHT_ARSTORE_S_UVAJENIEM")?><a href="http://<?= $SITE_SERVER_NAME ?>" target="_blank"
                                            style=" color:#fff;"><?= $SITE_SERVER_NAME ?></a></strong>
                    <br>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
</body>
</html>