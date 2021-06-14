(function() {

	'use strict';

	var methodsCloudWord = {

		scrollBox: {},
		tableWord: {},
		cloudWord: {},
		testData: {
			"listOfWords":[
			{
				"Key":"Fries",
				"Count":12491
			},
			{
				"Key":"none",
				"Count":10964
			},
			{
				"Key":"pizza",
				"Count":9350
			},
			{
				"Key":"chicken",
				"Count":8034
			},
			{
				"Key":"salad",
				"Count":6681
			},
			{
				"Key":"burgers",
				"Count":6338
			},
			{
				"Key":"Coffee",
				"Count":6061
			},
			{
				"Key":"steak",
				"Count":5061
			},
			{
				"Key":"soda",
				"Count":4563
			},
			{
				"Key":"burger",
				"Count":3951
			},
			{
				"Key":"drinks",
				"Count":3199
			},
			{
				"Key":"Ice Cream",
				"Count":3197
			},
			{
				"Key":"salads",
				"Count":3105
			},
			{
				"Key":"wings",
				"Count":2985
			},
			{
				"Key":"pasta",
				"Count":2961
			},
			{
				"Key":"Coke",
				"Count":2663
			},
			{
				"Key":"fish",
				"Count":2647
			},
			{
				"Key":"chips",
				"Count":2514
			},
			{
				"Key":"french fries",
				"Count":2405
			},
			{
				"Key":"na",
				"Count":2349
			},
			{
				"Key":"SANDWICHES ",
				"Count":2332
			},
			{
				"Key":"tacos",
				"Count":2325
			},
			{
				"Key":"Shrimp",
				"Count":2311
			},
			{
				"Key":"shakes",
				"Count":2309
			},
			{
				"Key":"beer",
				"Count":2225
			},
			{
				"Key":"soup",
				"Count":2130
			},
			{
				"Key":"drink",
				"Count":2114
			},
			{
				"Key":"Pancakes",
				"Count":2036
			},
			{
				"Key":"n/a",
				"Count":1905
			},
			{
				"Key":"sandwich",
				"Count":1872
			},
			{
				"Key":"Eggs",
				"Count":1788
			},
			{
				"Key":"Hamburger",
				"Count":1610
			},
			{
				"Key":"ribs",
				"Count":1570
			},
			{
				"Key":"Donuts",
				"Count":1568
			},
			{
				"Key":"tea",
				"Count":1496
			},
			{
				"Key":"salad bar",
				"Count":1461
			},
			{
				"Key":"burrito",
				"Count":1445
			},
			{
				"Key":"subs",
				"Count":1428
			},
			{
				"Key":"bread",
				"Count":1427
			},
			{
				"Key":"onion rings",
				"Count":1401
			},
			{
				"Key":"Biscuits",
				"Count":1361
			},
			{
				"Key":"nothing",
				"Count":1317
			},
			{
				"Key":"burritos",
				"Count":1274
			},
			{
				"Key":"Chicken Sandwich",
				"Count":1232
			},
			{
				"Key":"Breadsticks",
				"Count":1221
			},
			{
				"Key":"cookies",
				"Count":1155
			},
			{
				"Key":"taco",
				"Count":1141
			},
			{
				"Key":"bread sticks",
				"Count":1138
			},
			{
				"Key":"Hamburgers",
				"Count":1102
			},
			{
				"Key":"bagels",
				"Count":1028
			}
		]},

		jqCloudObject: {},

		init: function( scrollbox, tableID, cloudID ) {
			var self = this;

			self.scrollBox = $( scrollbox );
			self.tableWord = $( tableID );
			self.cloudWord = $( cloudID );

			self.ajaxQueryWord();
		},

		listeners: function() {
			var self = this;

			self.listenerTableSort();
			self.listenerHoverKeyWord();
			self.listenerSearchKeyWord();
		},

		ajaxQueryWord: function() {
			var self = this;

			// $.ajax({
			// 	url: "wordsforcloud.php",
			// 	data: "data",
			// 	type: 'GET',
			// 	error: self.ajaxFuncError.bind(self),
			// 	beforeSend: self.ajaxFuncBeforeSend.bind(self),
			// 	success: self.ajaxFuncSuccess.bind(self)
			// })

var stringifyTestData = JSON.stringify(self.testData)

			self.ajaxFuncSuccess(stringifyTestData)
		},

		ajaxFuncBeforeSend: function (data) {

		},

		ajaxFuncSuccess: function (data) {
			var self = this,
				dataPars = JSON.parse(data),
				keyObject = Object.keys(dataPars),
				i = dataPars[keyObject].length,
				obbAppend = '',
				obbConcat = '',
				strForChange = '',
				cloudObject = {};

			if( self.countOfOject(dataPars) !== 0 ) {

				$('.word-cloud-search span i').html(i);

				while(i--) {
					obbConcat = '<tr><td>'+ dataPars[keyObject][i]["Key"] +'</td><td>'+ dataPars[keyObject][i]["Count"] +'</td></tr>';
					obbAppend += obbConcat;
				}

				self.tableWord.append(obbAppend);
				self.scrollPaneBox();
			}

			// редактируем объект
			strForChange = data;
			strForChange = strForChange.replace(/Key/g, 'text');
			strForChange = strForChange.replace(/Count/g, 'weight');

			cloudObject = JSON.parse(strForChange);
			self.buildJqCloud( cloudObject );
		},

		ajaxFuncError: function (data) {

		},

		countOfOject: function(obj) {

			var i = 0,
				x;

			if (typeof(obj) != "object" || obj == null) return 0;
			for (x in obj) i++;
			return i;
		},

		scrollPaneBox: function () {
			var self = this;

			if( self.tableWord.height() > 245 ) {
				self.scrollBox.jScrollPane({
					showArrows: true,
					autoReinitialise: true
				}).data('jsp');
			}

		},

		buildJqCloud: function ( obj ) {

			var cloudObject = obj,
				self = this,
				jQCloudSetting = {
					classPattern: 'word-{n}',
					colors: ["#4c4c4c", "#636363", "#797979", "#909090", "#a6a6a6", "#bdbdbd", "#d3d3d3"],
					fontSize: ["100px", "85px", "65px", "55px", "45px", "25px", "15px"],
					steps: 7,
					autoResize: true,
					center: {x: 430, y:245},
					shape: 'rectangular',
					delay: 10,
					afterCloudRender : function(){
						self.jqCloudObject = cloudObject;
						self.listenerHoverKeyWord();
					}
					// width: 858,
					// height: 490
				};

			self.cloudWord.jQCloud( cloudObject.listOfWords, jQCloudSetting );

			self.listenerTableSort();
			self.listenerSearchKeyWord();
		},

		listenerTableSort: function() {
			var self = this;

			self.tableWord.tablesorter({
				sortList: [[1,1]]
			});

			$(".cloud-btn button").on( "click", function() {
				var $this = $(this),
					idButton = $this.attr('id'),
					sorterTrigger = $('.tablesorter-headerRow');

				switch (idButton) {
					case "count":
						sortAndStatusBtn('last', $this);
						break;
					case "key":
						sortAndStatusBtn('first', $this);
						break;
					default:
						console.log('id не задано');
						break;
				}

				function sortAndStatusBtn(e, th) {
					var nameSortAddBtn = $('th:'+ e +'-child', sorterTrigger).trigger('click').attr('aria-sort');

					if(nameSortAddBtn === 'none') {
						th.siblings().removeClass( "descending ascending" );
						th.removeClass( "none" ).addClass( 'descending' );
						return
					}

					th.removeClass( "descending ascending none" ).addClass( nameSortAddBtn );
				}
			});
		},

		listenerHoverKeyWord: function() {
			var self = this,
				cloudObjSpan = $('#js-cloud span');

			$( 'tbody tr', self.tableWord ).on({
				mouseenter: function(){

					var innerSpan = $('td:first-child', this).html();

					$.each( cloudObjSpan, function( key, value ) {

						if( value.innerHTML.indexOf( innerSpan ) === 0 && innerSpan.length === value.innerHTML.length) {
							$(value).addClass('active');
						}
					});
				},
				mouseleave: function(){

					$.each( cloudObjSpan, function( key, value ) {

						if( value.className.indexOf( 'active' ) > 0 ) {
							$(value).removeClass('active');
						}

					});
				}
			});
		},

		listenerSearchKeyWord: function() {
			var self = this,
				tdObjForFilter = $('tbody tr td:first-child',self.tableWord),
				filtrJqCloudObject = {},
				beforeBackspace = 0;

			$('#js-search').keyup( function(e) {

				var searchWord = $(this).val().toLowerCase();

				if( searchWord === '' && e.keyCode === 8 && beforeBackspace === 0 ) {
					beforeBackspace = 8;
				} else if ( searchWord === '' && e.keyCode === 8 && beforeBackspace === 8 ) {
					return
				} else {
					beforeBackspace = 0;
				}

				filtrJqCloudObject = self.jqCloudObject.listOfWords.filter( function(n, i){
					return ( n.text.toLowerCase().indexOf( searchWord )  !== -1 );
				});

				$.each( tdObjForFilter, function( key, value ) {

					if( value.innerHTML.toLowerCase().indexOf( searchWord ) === -1 ) {
						$(value).closest('tr').attr('style','display:none');
					} else {
						$(value).closest('tr').attr('style','display:block');
					}
				});

				self.cloudWord.jQCloud('update', filtrJqCloudObject)
			});
		},
	};

	function CloudWord( scrollbox, tableID, cloudID ) {
		function cloudWord() {}
		cloudWord.prototype = methodsCloudWord;
		var plaginCloud = new cloudWord();
		plaginCloud.init( scrollbox, tableID, cloudID );
		return plaginCloud;
	}

	var cloudWord = new CloudWord( ".cloud-table--scroll","#cloud-table", "#js-cloud");

})();