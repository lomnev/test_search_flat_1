<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BN.RU mini-parser</title>
    <link rel="stylesheet" type="text/css" href="/css/css.css"/>
    <script type="text/javascript" src="/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/js/js.js"></script>
</head>
<body>
<header>BN.RU mini-parser</header>
<div class="container">

    <div class="search_block">
        <form action="" id="search_form" method="POST" name="search_form">
            <div class="search_left">
                <div class="search_input_block">
                    <div class="title">Комнат от:</div>
                    <div class="field">
                        <input type="text" name="kkv1" maxlength="2" size="3" value="<?=isset($_SESSION['minFlat'])?$_SESSION['minFlat']:'0'?>" placeholder="только цифры...">
                    </div>
                </div>
                <div class="search_input_block">
                    <div class="title">Комнат до:</div>
                    <div class="field">
                        <input type="text" name="kkv2" maxlength="2" size="3" value="<?=isset($_SESSION['maxFlat'])?$_SESSION['maxFlat']:'8'?>" placeholder="только цифры...">
                    </div>
                </div>
                <div class="search_input_block">
                    <div class="title">Цена от, т.р.:</div>
                    <div class="field">
                        <input type="text" name="price1" size="3" maxlength="10" value="<?=isset($_SESSION['minPrice'])?$_SESSION['minPrice']:'1'?>" placeholder="только цифры...">
                    </div>
                </div>

                <div class="search_input_block">
                    <div class="title">Цена до, т.р.:</div>
                    <div class="field">
                        <input type="text" name="price2" size="3" maxlength="10" value="<?=isset($_SESSION['maxPrice'])?$_SESSION['maxPrice']:'100000'?>" placeholder="только цифры...">
                    </div>
                </div>

            </div>
            <div class="search_right">
                <select name="metro[]" id="metro[]" size="9" multiple="">
                    <?php foreach($this->dataProvider as $oneMetro) { ?>
                        <option value="<?=$oneMetro['metro_value']?>" <?=$oneMetro['selected']?>><?=$oneMetro['metro_title']?></option>
                    <?php } ?>
                </select>
                <input type="submit" id="btn_submit_search" value="Найти">
            </div>
        </form>
    </div>

    <div class="result_block">
        <div class="cm_standard_header"><h2>Результаты поиска</h2></div>
        <div id="results_here">
            <?php (new Page((new SearchRequest)->getResultsArray()))->render("_results_partial"); ?>
        </div>
    </div>

    <footer>
        &copy; 2013, <a href="http://lomnev.ru">LV</a>.
    </footer>
</div>
</body>
</html>


