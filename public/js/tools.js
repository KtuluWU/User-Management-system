// 常用的一些函数写在这个文件了

function Counter(array) {
    let count = {};
    array.forEach(val => count[val] = (count[val] || 0) + 1);
    return count;
}


function dateToYms(d) {
    let month = ('' + (d.getMonth() + 1)).padStart(2, '0');
    let day = ('' + d.getDate()).padStart(2, '0');
    let year = d.getFullYear();
    return [year, month, day].join('-');
}

function handleFile() {
    var file = document.getElementById("form_submitFile");
    var fileName = document.getElementById("filename_display");
    fileName.value = file.value;
}

function get_option_list(option_name){
    return function () {
        let option_list = null;
        $.ajax({
            'async': false,
            'type': "GET",
            'global': false,
            'dataType': 'html',
            'url': "/service/get_option_list/optionname="+encodeURIComponent(option_name),
            'success': function (data) {
                option_list = JSON.parse(JSON.parse(data));
            }
        });
        return option_list;
    }();
}

function parseDC2Array(dc2array){
    let re = /"(.*)"/gm;
    let match = re.exec(dc2array);
    let parsed = [];
    while (match != null){
        parsed.push(match[1]);
        match = re.exec(dc2array);
    }
    return parsed;
}


function translate(pattern) {
    return function () {
        let tmp = null;
        $.ajax({
            'async': false,
            'type': 'GET',
            'global': false,
            'dataType': 'html',
            'url': "/service/translate/pattern=" + pattern,
            'success': function (data) {
                tmp = JSON.parse(data);
            }
        });
        if (tmp === null) {
            tmp = pattern;
        }
        return tmp;
    }();
}


function put_query_by_option_index(i, option_mapping, search_block, field_list){
    let text_search_query = '<input style="margin-left: 20px; margin-right: 20px" type="text" size="60" class="search_query">';
    let option_search_query = '<select style="margin-left: 20px; margin-right: 20px" class="search_query"></select>';

    search_block.find('.search_query').empty().remove();
    if (option_mapping[field_list[i]] !== undefined){
        search_block.append(option_search_query);
        for (idx in option_mapping[field_list[i]]){
            let translated = option_mapping[field_list[i]][idx];
            search_block.find('.search_query').append('<option name="'+ field_list[i] +'" value="'+ idx +'">'+translated+'</option>')
        }
    }else{
        search_block.append(text_search_query);
    }
    search_block.find('.search_query').insertBefore(search_block.find('.search_submit'));
}


$.fn.renderTable = function (table_name, page_number, sort_field, sort_order, count, where_clause, insert_records, default_clause=null) {
    let record_table = $(this);
    $.ajax({
        url: "/service/get_general_list_with_count/table="+table_name+"&page="+page_number+"&orderedby="+sort_field+"&order="+sort_order+"&count="+count+"&where="+encodeURIComponent(where_clause),
        type: "GET",
        success: function(info) {
            record_table.find('tbody tr').not(':first').remove();
            let json_data = JSON.parse(info);
            let so = sort_order;
            let pn = page_number;
            let sf = sort_field;
            let wc = where_clause;
            let c = json_data['record_count'];
            if (!default_clause){
                default_clause = where_clause;            // 记录最初条件从句，用于搜索
            }
            $(function() {
                record_table.find('.record_table_pagination').pagination('updateItems', c);
            });
            insert_records(json_data['list'], record_table);
            if(!record_table.find('.record_table_pagination').length){
                let sortables = record_table.find('thead tr .sortable');
                let field_list = sortables.map(function () {
                    return $(this).attr('sortfield');
                }).get();
                let field_name_list = sortables.map(function () {
                    return $(this).text();
                }).get();
                let option_list_field = sortables.map(function () {
                    let option_list_val = $(this).attr('optionlist');
                    if (typeof option_list_val !== typeof undefined && option_list_val !== false){
                        return option_list_val;
                    }
                    return '';   // flag，js的map如果返回null会被过滤掉，这里为了让三个list长度一致
                }).get();

                let option_translation_mapping = [];
                for (i in option_list_field){
                    if (option_list_field[i] !== ''){   // flag check
                        option_translation_mapping[field_list[i]] = get_option_list(option_list_field[i]);
                    }
                }

                record_table.prepend("<div class='search_block' style='margin-bottom:10px;'>查找记录：<select class='search_field'></select></div>");
                let search_block = record_table.find('.search_block');
                for (i in field_name_list){
                    search_block.find('.search_field').append('<option name="'+ field_list[i] +'" value="'+ field_name_list[i] +'">'+field_name_list[i]+'</option>')
                }

                put_query_by_option_index(0, option_translation_mapping, search_block, field_list, option_list_field);

                search_block.find('.search_field').change(function (){
                    let selected_text = search_block.find('.search_field').val();
                    let i = search_block.find('.search_field option[value='+ selected_text +']').index();
                    put_query_by_option_index(i, option_translation_mapping, search_block, field_list, option_list_field);
                });

                search_block.append('<input type="submit" value="查找" class="search_submit">');

                search_block.find('.search_submit').click(function () {
                    pn = 1;
                    if (search_block.find('.search_query').val() !== ''){
                        wc = default_clause + " AND "+search_block.find('.search_field option:selected').attr("name")+" LIKE '%"+search_block.find('.search_query').val()+"%'";
                    }else{
                        wc = default_clause;
                    }
                    record_table.renderTable(table_name, pn, sf, so, count, wc, insert_records, default_clause);
                });

                let first_col = record_table.find('thead tr .sortable').first();
                first_col.css("background", "darkgrey");
                first_col.addClass('sorting_desc');
                first_col.append("<i class='fa fa-sx fa-sort-up'></i>");

                record_table.find('thead tr .sortable').click(function (e){
                    e.preventDefault();
                    if ($(this).hasClass('sorting_desc')){
                        $(this).removeClass('sorting_desc').addClass('sorting_asc');
                        $(this).find("i").remove();
                        $(this).append("<i class='fa fa-sx fa-sort-up'></i>");
                        so = "ASC";
                        sf = $(this).attr('sortfield');
                    }else if ($(this).hasClass('sorting_asc')){
                        $(this).removeClass('sorting_asc').addClass('sorting_desc');
                        $(this).find("i").remove();
                        $(this).append("<i class='fa fa-sx fa-sort-down'></i>");
                        so = "DESC";
                        sf = $(this).attr('sortfield');
                    }else{
                        record_table.find('thead tr .sorting_desc, .sorting_asc').css("background", "white");
                        record_table.find('thead tr .sorting_desc, .sorting_asc').find("i").remove();
                        record_table.find('thead tr .sorting_desc, .sorting_asc').removeClass("sorting_desc sorting_asc");
                        $(this).css("background", "darkgrey");
                        $(this).addClass('sorting_desc');
                        $(this).append("<i class='fa fa-sx fa-sort-down'></i>");
                        so = "DESC";
                        sf = $(this).attr('sortfield');
                    }
                    pn = 1;
                    record_table.find('.record_table_pagination').pagination('selectPage', pn);
                    record_table.renderTable(table_name, pn, sf, so, count, wc, insert_records);
                });
                record_table.append('<div class="record_table_pagination"></div>');
                record_table.find('.record_table_pagination').pagination({
                    items: json_data['record_count'],
                    itemsOnPage: 10,
                    cssStyle: 'light-theme',
                    onPageClick: function(pageNumber, event) {
                        pn = pageNumber;
                        record_table.renderTable(table_name, pn, sf, so, count, wc, insert_records);
                    },
                });
            }
        },
    });
}