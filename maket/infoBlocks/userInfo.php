<div class='container'>
    <div style="float: left;">
        <img style="width: 200px; height: 200px;" src='<? echo "/img/users/".$userInfo[img];?>' alt="" />
    </div>
    <div style="padding: 10px; float:left; width: 55% ">
        <p style="font-weight: bold; margin: 10px 0">Информация о пользователе
            <? echo $userInfo[login];?>
        </p>
        <div style="margin-top: 20px">
            <div class="divTitle">ФИО: </div>
            <? echo $userInfo[fio];?>
            <div style="clear: both"></div>
        </div>
        <div style="margin-top: 20px">
            <div class="divTitle">e-mail: </div>
            <? echo $userInfo[mail];?>
            <div style="clear: both"></div>
        </div>
    </div>
    <div style="clear: both"></div>
</div>