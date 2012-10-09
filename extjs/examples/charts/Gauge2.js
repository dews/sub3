/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require(['Ext.chart.*', 'Ext.chart.axis.Gauge', 'Ext.chart.series.*', 'Ext.Window']);

Ext.onReady(function () {

    Ext.create('Ext.Window', {
        width: 1000,
        height: 250,
        minWidth: 650,
        minHeight: 225,
        title: '電源使用量',
        tbar: [{
            text: '更新數據',
            handler: function() {
                store1.loadData(generateData(1));
                store3.loadData(generateData(1));
                store4.loadData(generateData(1));
            }
        }],
        layout: {
            type: 'hbox',
            align: 'stretch'
        },
        items: [{
            xtype: 'chart',
            style: 'background:#fff',
			//三個動畫不同
            animate: {
                easing: 'elasticIn',
                duration: 1000
            },
            store: store1,
            insetPadding: 25,
            flex: 1,
            axes: [{
                type: 'gauge',
                position: 'gauge',
                minimum: 0,
                maximum: 100,
				//數值步進，max-min除steps，等於間隔。
                steps: 10,
				//數值內外
                margin: 7,
				title:"客廳"
            }],
            series: [{
                type: 'gauge',
                field: 'data1',
                donut: false,
				//甜甜圈內縮值
                colorSet: ['#F49D10', '#ddd']
            }]
        }, {
            xtype: 'chart',
            style: 'background:#fff',
            animate: true,
            store: store3,
            insetPadding: 25,
            flex: 1,
            axes: [{
                type: 'gauge',
                position: 'gauge',
                minimum: 0,
                maximum: 100,
                steps: 10,
                margin: 7,
				title:"臥室"
            }],
            series: [{
                type: 'gauge',
                field: 'data1',
                donut: 30,
                colorSet: ['#82B525', '#ddd']
            }]
        }, {
            xtype: 'chart',
            style: 'background:#fff',
            animate: {
                easing: 'bounceOut',
                duration: 500
            },
            store: store4,
            insetPadding: 25,
            flex: 1,
            axes: [{
                type: 'gauge',
                position: 'gauge',
                minimum: 0,
                maximum: 100,
                steps: 10,
                margin: 7,
				title:"浴室"
            }],
            series: [{
                type: 'gauge',
                field: 'data1',
                donut: 30,
                colorSet: ['#82B525', '#ddd']
            }]
        }, {
            xtype: 'chart',
            style: 'background:#fff',
            animate: true,
            store: store3,
            insetPadding: 25,
            flex: 1,
            axes: [{
                type: 'gauge',
                position: 'gauge',
                minimum: 0,
                maximum: 100,
                steps: 10,
                margin: 7,
				title:"陽台"
            }],
            series: [{
                type: 'gauge',
                field: 'data1',
                donut: 30,
                colorSet: ['#82B525', '#ddd']
            }]
        }, {
            xtype: 'chart',
            style: 'background:#fff',
            animate: true,
            store: store3,
            insetPadding: 25,
            flex: 1,
            axes: [{
                type: 'gauge',
                position: 'gauge',
                minimum: 0,
                maximum: 100,
                steps: 10,
                margin: 7,
				title:"廚房"
            }],
            series: [{
                type: 'gauge',
                field: 'data1',
                donut: 30,
                colorSet: ['#82B525', '#ddd']
            }]
        }]
    }).show();
    
});
