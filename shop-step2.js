
"use strict";

// hide local variables scope
(function()
{
	// jQuery-style notation
	var $ = function (a) { return document.getElementById(a);}

    var myitems = [ {name:"ASUS nVidia GT210",icon:"ASUS_nVidia_GT210.jpg", desc:"ASUS nVidia GT210 ― доступна відеокарта для робочого, або мультимедійного ПК. Виготовлена із добірних компонентів та матеріалів на основі відеоядра GT210, що забезпечує чудову швидкодію у щоденній роботі та під час декодування відео. А низькопрофільне виготовлення карти та пасивна система охолодження роблять ASUS nVidia GT210 ідеальним вибором для комплектації продуктивної мультимедійної системи HTPC. Відеокарта підтримує максимальне розширення до 2560x1600 точок, що дозволяє під'єднавши до неї два широкоформатних монітора повністю поринути у цифровий світ", price:985},
					{name:"ASUS HD5450",icon:"ASUS_HD5450.jpg", desc:"Відеокарта ASUS HD5450 забеспечує якісну передачу зображення, та підійде як для ігор, так і для роботи. ASUS використовує ексклюзивні системи охолодження, так що може здійснювати охолодження працюючої системи безшумно та якісно. Завдяки її розмірам, чудово підійде до будь-якого системного блоку.", price:1057},
					{name:"Gigabyte GT 610",icon:"Gigabyte_GT_610.jpg", desc:"Відеокарта бюджетного класу Gigabyte GT 610 задовольнить своєю продуктивністю під час щоденних задач. Доступний HDMI-роз'єм завдяки позолоченим контактам забезпечить якісну передачу сигналу. Підтримка Nvidia PhysX дозволить насолодитись фізичними ефектами в іграх, що зробить їх більш реалістичними та динамічними. В пристрої активна система охолодження, яка складається з швидкого та водночас тихого вентилятора в компанії з надійним радіатором. Шанс перегрівання зменшується, тому робота буде стабільною.", price:1250}, 
					{name:"Sapphire R5 230 Silent",icon:"Sapphire_R5_230_Silent.jpg", desc:"Sapphire R5 230 Silent - бюджетна відеокарта, основою якої став чіп R5 230, виготовлений компанією AMD. Чудово підійде для зборки недорого домашнього чи офісного комп’ютера, що призначений для роботи, перегляду відео чи гри в нескладні ігри. Наділена 1ГБ відеопам'яті, що забезпечує продуктивність якої більше ніж достатньо для щоденної роботи. Карта апаратно підтримує Microsoft DirectX 11, Shader Model 5.0, OpenGL 4.1, щоб забезпечити максимальну сумісність із всіма сучасними додатками. Sapphire R5 230 Silent - чудовий вибір для комплектації мініатюрного медіа-центра, або робочого ПК.", price:2848}, 
					{name:"Gigabyte HD5450",icon:"Gigabyte_HD5450.jpg", desc:"Gigabyte HD5450 - бюджетна низькопрофільна відеокарта. Її основою став чіп HD 5450, що виготовлений компанією AMD. Карта чудово підійде для зборки недорого домашнього чи офісного комп’ютера, що призначений для роботи, перегляду відео чи гри в не складні ігри. Наявність порту HDMI надасть можливість під’єднати ПК з цією відеокартою до телевізора, а її компактні розміри забезпечать універсальність встановлення у будь-який комп’ютерний корпус.", price:897}, 
					{name:"EVGA GT210",icon:"EVGA_GT210.jpg", desc:"EVGA GT210 - дискретна відеокарта початкового типу, призначена для персональних ПК. Компактна конструкція і висока енергоефективність роблять цю відеокарту прекрасним вибором для стаціонарних мультимедійних систем. Пасивна система охолодження забезпечує абсолютно безшумну роботу відеокарти. Підтримка HDMI дозволяє переглядати відео з роздільною здатністю Full HD 1080p.", price:985} ];
 
	var calculatePrice = function()
	{
		 var price = 0;
		 var atLeastOneIsSelected = false;
		 for(var i in myitems)
		 {
			 var checkid = "itemcheck_"+i;
			 if ($(checkid).checked) { price += myitems[i].price; atLeastOneIsSelected = true; }
		 }
		 return [price, atLeastOneIsSelected];
	}
 
    var selection_change_f = function()
    {
		var price = calculatePrice();// [price, is_selected]
		$("totalprice").innerHTML = "Сума замовлення: " + price[0].toFixed(2) + " грн.";
		$("buybutton").disabled = !price[1];
    }
	
	$("buybutton").onclick = function()
	{
		$('dialogprice').innerHTML = calculatePrice()[0].toFixed(2);
		$('buydialog').style.display='block';
	}

    var itemcontainer = $("itemcontainer");
	itemcontainer.innerHTML = '<hr>';

    for(var i in myitems)
    {
        var item = myitems[i];
        item.price = Number.parseFloat(item.price); // make sure it is a number

        var nameid = "itemname_"+i;
        var textid = "itemtext_"+i;
        var checkid = "itemcheck_"+i;

        itemcontainer.innerHTML +=	'<div class="w3-row"><div class="w3-col s4 m2">' +
									'<img src="' + item.icon + '" style="width:100%"></img></div>' +
									'<div class="w3-col s8 m7 w3-container"><h3 id="'+nameid+'"></h3>' +
									'<p id="'+textid+'"></p></div><div class="w3-col s12 m3 w3-container">' +
									'<h3><input id="' + checkid + '" type="checkbox"></input>&nbsp;'+item.price+' UAH</h3></div></div><hr>';

        $(nameid).appendChild(document.createTextNode(item.name));
        $(textid).appendChild(document.createTextNode(item.desc));
    }
	
	for(var i in myitems)
	{
		$("itemcheck_"+i).onchange = selection_change_f;
	}
	
	selection_change_f();
})();

