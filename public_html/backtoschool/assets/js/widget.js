(function(window,document){"use strict";var $grid;var data_storage;var original_data;var last_key;var env_urls=skGetEnvironmentUrls('google-calendar');var app_url=env_urls.app_url;var app_backend_url=env_urls.app_backend_url;var app_file_server_url=env_urls.app_file_server_url;var sk_img_url=env_urls.sk_img_url;var sk_app_url=env_urls.sk_app_url;var sk_api_url=env_urls.sk_api_url;var current_position=0;var event_counter=0;var el=document.getElementsByClassName('sk-ww-google-calendar')[0];el.innerHTML="<div class='first_loading_animation' style='text-align:center; width:100%;'><img src='"+app_url+"images/ripple.svg' class='loading-img' style='width:auto !important;' /></div>";loadCssFile(app_url+"libs/js/magnific-popup/magnific-popup.css");loadCssFile("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");loadCssFile(app_url+"libs/js/flatpickr/flatpickr.min.css");loadCssFile(app_url+"libs/js/swiper/swiper.min.css");loadCssFile(app_url+"libs/js/swiper/swiper.css");console.log('load jquery')
var j_version=0;if(window.jQuery!==undefined){j_version=window.jQuery.fn.jquery;j_version=j_version?parseInt(j_version.charAt(0)):4;}
if(window.jQuery===undefined||j_version<3){var script_tag=document.createElement('script');script_tag.setAttribute("type","text/javascript");script_tag.setAttribute("src","https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");if(script_tag.readyState){script_tag.onreadystatechange=function(){if(this.readyState=='complete'||this.readyState=='loaded'){scriptLoadHandler();}};}else{script_tag.onload=scriptLoadHandler;}
(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(script_tag);}else{jQuery=window.jQuery;scriptLoadHandler();}
function loadScript(url,callback){var scriptTag=document.createElement('script');scriptTag.setAttribute("type","text/javascript");scriptTag.setAttribute("src",url);if(typeof callback!=="undefined"){if(scriptTag.readyState){scriptTag.onreadystatechange=function(){if(this.readyState==='complete'||this.readyState==='loaded'){callback();}};}else{scriptTag.onload=callback;}}
(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(scriptTag);}
function scriptLoadHandler(){loadScript(app_url+"libs/magnific-popup/jquery.magnific-popup.js",function(){loadScript("https://unpkg.com/masonry-layout@4.2.0/dist/masonry.pkgd.min.js",function(){loadScript(app_url+"libs/flatpickr/flatpickr.min.js",function(){loadScript(app_url+"libs/js/moment.js",function(){loadScript(app_url+"libs/swiper/swiper.min.js",function(){loadScript(app_url+"libs/js/moment-timezone.js",function(){$=jQuery=window.jQuery.noConflict(true);main();});});});});});});}
function loadCssFile(filename){var fileref=document.createElement("link");fileref.setAttribute("rel","stylesheet");fileref.setAttribute("type","text/css");fileref.setAttribute("href",filename);if(typeof fileref!="undefined"){document.getElementsByTagName("head")[0].appendChild(fileref)}}
function getDsmEmbedId(sk_ww_google_calendar){var embed_id=sk_ww_google_calendar.attr('embed-id');if(embed_id==undefined){embed_id=sk_ww_google_calendar.attr('data-embed-id');}
return embed_id;}
function getDsmSetting(sk_ww_google_calendar,key){return sk_ww_google_calendar.find("."+key).text();}
function highlightSkGoogleCalendarTab(clicked_tab,sk_ww_google_calendar){clicked_tab.closest('.sk-ww-google-calendar').find('.sk_google_cal_tabs_container div').css({'background-color':'#999999','color':'#ffffff'});clicked_tab.css({'background-color':getDsmSetting(sk_ww_google_calendar,'tab_bg_color'),'color':getDsmSetting(sk_ww_google_calendar,'tab_text_color')});}
function initializeFlatpickr_SkGoogleCalendar(sk_ww_google_calendar){var selected_date=localStorage.getItem('sk_google_cal_selected_date');if(typeof flatpickr==="undefined"){sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val(selected_date);}
else{var dateFormat=getDsmSetting(sk_ww_google_calendar,"date_format");if(dateFormat){dateFormat='M d, Y';}
var language_code=languageCode(getDsmSetting(sk_ww_google_calendar,"translation"));flatpickr(".sk_google_cal_date_picker_input",{defaultDate:selected_date,allowInput:true,format:dateFormat,altFormat:dateFormat,altInput:true,locale:language_code,onOpen:function(selectedDates,dateStr,instance){jQuery('.flatpickr-calendar').css({'font-family':getDsmSetting(sk_ww_google_calendar,"font_family")});}});}}
function getTodayMonthDayCommaYear(selected_date){if(jQuery("input[class='sk_google_cal_date_picker_input flatpickr-input form-control input']").val()==undefined){return jQuery("input[class='hidden_el sk_google_cal_date_picker_input flatpickr-input form-control input']").val();}else{return jQuery("input[class='sk_google_cal_date_picker_input flatpickr-input form-control input']").val();}}
function makeLinkOpenNewTab(){$.each(jQuery('.sk_event_description'),function(i,v){$(v).find('a').attr('target','_blank');});$.each(jQuery('.sk-post-text'),function(i,v){$(v).find('a').attr('target','_blank');})}
function getTodayYmd(){var today=new Date();var dd=today.getDate();var mm=today.getMonth()+1;var yyyy=today.getFullYear();if(dd<10){dd='0'+dd}
if(mm<10){mm='0'+mm}
return yyyy+'-'+mm+'-'+dd;}
function getFullMonthName(month){var english_month_names=["January","February","March","April","May","June","July","August","September","October","November","December"];return english_month_names[month];}
function ordinal_suffix_of(i){var j=i%10,k=i%100;if(j==1&&k!=11){return i+"st";}
if(j==2&&k!=12){return i+"nd";}
if(j==3&&k!=13){return i+"rd";}
return i+"th";}
function replaceContentWithLinks(html,sk_ww_google_calendar){var text=html.html();if(text){text=text.replace(/(\r\n|\n\r|\r|\n)/g,"<br>");text=replaceHttpToLink(text);html.html(text);}}
function replaceHttpToLink(content)
{if(typeof content.replaceAll!=="undefined")
content=content.replaceAll("<br>"," <br>");content=content.replace('<br>https','<br> https');content=content.replace('<br>http','<br> http');var splitted_text=content.split(' ');if(splitted_text&&splitted_text.length>0){jQuery.each(splitted_text,function(key,value){if(value.indexOf('http')!=-1&&value.charAt(0)=="h"&&value.charAt(1)=="t"){content=content.replace(' '+value,' <a target="_blank" href="'+value+'">'+value+'</a>');}});}
return content;}
function moderateMonthData(data_storage,search_term,selected_date){selected_date=new Date(selected_date);var selected_date_start=new Date(selected_date.getFullYear(),selected_date.getMonth(),1).getTime();var selected_date_end=new Date(selected_date.getFullYear(),selected_date.getMonth()+1,0).getTime();var new_data=[];jQuery.each(data_storage,function(index,value){var start_date=new Date(value.start_date).getTime();if(start_date>=selected_date_start&&selected_date_end>=start_date){new_data.push(value);}});return new_data;}
function searchData(data_storage,search_term){var new_data=[];jQuery.each(data_storage,function(index,value){var to_search_1=value.description?value.description:"";var to_search_2=to_search_1?to_search_1:"";to_search_2=to_search_2?to_search_2.toLowerCase():to_search_2;to_search_2=to_search_2?to_search_2.replace("'",''):to_search_2;to_search_2=to_search_2?to_search_2.replace("'",''):to_search_2;to_search_2=to_search_2?to_search_2.replace("'",''):to_search_2;to_search_2=to_search_2?to_search_2.replace("'",''):to_search_2;var to_search_3=value.name?value.name:"";var to_search_4=to_search_3?to_search_3.toLowerCase():"";to_search_4=to_search_4?to_search_4.replace("'",''):to_search_4;to_search_4=to_search_4?to_search_4.replace("'",''):to_search_4;to_search_4=to_search_4?to_search_4.replace("'",''):to_search_4;to_search_4=to_search_4?to_search_4.replace("'",''):to_search_4;search_term=search_term?search_term.toLowerCase():search_term;if(!search_term){new_data.push(value);}
else if((to_search_1&&to_search_1.toLowerCase().indexOf(search_term)!=-1)||(to_search_3&&to_search_3.toLowerCase().indexOf(search_term)!=-1)){new_data.push(value);}
else if((to_search_2&&to_search_2.toLowerCase().indexOf(search_term)!=-1)||(to_search_4&&to_search_4.toLowerCase().indexOf(search_term)!=-1)){new_data.push(value);}});return new_data;}
function moderateData(data_storage,search_term,selected_date,sk_ww_google_calendar){var excluded_posts="";if(getDsmSetting(sk_ww_google_calendar,"excluded_posts")!=""){excluded_posts=getDsmSetting(sk_ww_google_calendar,"excluded_posts");}
var new_data=[];selected_date=new Date(selected_date).getTime();jQuery.each(data_storage,function(index,value){var temp_start_time_raw=value.start_time_raw.split("T")[0];var temp_end_time_raw=value.end_date_raw.split("T")[0];var start_date=new Date(temp_start_time_raw).getTime();var end_date=new Date(temp_end_time_raw).getTime();if(selected_date>start_date&&selected_date>end_date){}
else if(excluded_posts&&excluded_posts.indexOf(value.eid)!=-1){}
else{new_data.push(value);}});new_data.sort(function(a,b){return new Date(a.start_date_raw).getTime()-new Date(b.start_date_raw).getTime();});return new_data;}
function reformatData(data_storage,sk_ww_google_calendar){var new_data=[];jQuery.each(data_storage,function(index,value){var temporary_div=document.createElement('div');temporary_div.innerHTML=value.description;value.description=temporary_div.innerHTML;new_data.push(value);});return new_data;}
function applyDateFormat(data_storage,sk_ww_google_calendar){var use_24_hour_clock=getDsmSetting(sk_ww_google_calendar,'use_24_hour_clock');var timezone=getDsmSetting(sk_ww_google_calendar,'timezone');var dateFormat=getDsmSetting(sk_ww_google_calendar,"date_format");var format='h:mm A';jQuery.each(data_storage,function(index,value){if(use_24_hour_clock==1){format='HH:mm';}
var timeZoneInSettings=moment.tz(value.start_date,timezone);var offset=timeZoneInSettings.utcOffset()/60;if(value.timezone!="UTC"){offset=0;}
if(dateFormat=="d-m-Y"){dateFormat="DD-MM-YYYY"}
if(dateFormat=="YYYY MMM Do"){dateFormat="YYYY MMM Do"}
var start_date_time=value.start_date_raw;var end_date_time=value.end_date_raw;if(start_date_time){start_date_time=start_date_time.split("T")[0];}
if(end_date_time){end_date_time=end_date_time.split("T")[0];}
data_storage[index].start_date=moment(start_date_time).format(dateFormat);data_storage[index].end_date=moment(end_date_time).format(dateFormat);if(value.start_date_time&&value.timezone!="UTC"){data_storage[index].start_time=moment(value.start_date_time).format(format);data_storage[index].end_time=moment(value.end_date_time).format(format);}
else{data_storage[index].start_time=moment(value.start_time_raw).tz(timezone).format(format);data_storage[index].end_time=moment(value.end_time_raw).tz(timezone).format(format);}});return data_storage;}
function exportTranslation(sk_ww_google_calendar,embed_id){var temp_app_file_server_url=app_file_server_url.replace("feed/","");var export_calendar_url=temp_app_file_server_url+"widget_export_calendar/"+embed_id+"?nocache="+(new Date()).getTime();var export_calendar_webcal_url=export_calendar_url.replace("https://www.","webcal://");var basic_html="";basic_html+="<div class='sk_ww_google_calendars_export_tab_title'>Export to Google Calendar</div>";basic_html+="<div class='container_sk_ww_google_calendars_export_tabs'>";basic_html+="<div class='sk_ww_google_calendars_export_tab sk_ww_google_calendars_export_tab_active' data-clicked-tab='download'>Download</div>";basic_html+="<div class='sk_ww_google_calendars_export_tab' data-clicked-tab='subscribe'>Subscribe</div>";basic_html+="</div>";basic_html+="<div class='container_sk_ww_google_calendars_export_tab_content'>";basic_html+="<div class='sk_ww_google_calendars_export_tab_content sk_export_to_download' style='display:block;'>";basic_html+="Get a copy of our current events calendar. ";basic_html+="Follow the simple steps below.<br /><br />";basic_html+="<b>Create New Calendar</b><br />";basic_html+="1. Download the calendar file here: <a href='"+export_calendar_url+"'>";basic_html+="ICS File";basic_html+="</a>.<br />";basic_html+="2. Open your <a href='https://calendar.google.com' target='_blank'>Google Calendar</a>.<br />";basic_html+="3. On the left side, see \"Add friend's calendar\" field.<br />";basic_html+="4. Click the plus (+) icon > click \"New calendar\" option.<br />";basic_html+="5. Enter '"+getDsmSetting(sk_ww_google_calendar,"name")+"' as calendar name.<br />";basic_html+="6. Click the \"Create calendar\" button.<br />";basic_html+="7. Once created, click the back button.<br /><br />";basic_html+="<b>Import Calendar</b><br />";basic_html+="1. On the left side, see \"Add friend's calendar\" field.<br />";basic_html+="2. Click the plus (+) icon > click \"Import\" option.<br />";basic_html+="3. Select the ICS file we downloaded earlier.<br />";basic_html+="4. Select the calendar name we created earlier.<br />";basic_html+="5. Click 'Import' button.<br />";basic_html+="6. Done!";basic_html+="</div>";basic_html+="<div class='sk_ww_google_calendars_export_tab_content sk_export_to_subscribe'>";basic_html+="Receive our event updates automatically. ";basic_html+="Follow all the simple steps below.<br /><br />";basic_html+="<b>Add Calendar URL</b><br />";basic_html+="1. Open your <a href='https://calendar.google.com' target='_blank'>Google calendar</a>.<br />";basic_html+="2. On the left side, see \"Add friend's calendar\" field.<br />";basic_html+="3. Click the plus (+) icon > click \"From URL\" option.<br />";basic_html+="4. On \"URL of calendar\" field, copy and paste the following link:<br /><input type='text' id='sk-google-cal-url-value' value='"+export_calendar_webcal_url+"'><br />";basic_html+="<button class='btn-copy-google-cal-url'><i class='fa fa-clipboard'></i> Copy URL</button><br />"
basic_html+="5. Click 'Add Calendar' button. Loading will take 2-3 minutes.<br />";basic_html+="6. After 2-3 minutes, refresh Google calendar.<br />";basic_html+="7. See the left side if your calendar was loaded.<br /><br /></div>";return basic_html;}function renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date){var htmlContent="";var FebNumberOfDays="";var counter=1;var from=selected_date.split("-");var year=from[0];var month=from[1];var day=from[2];var new_year=year;var new_month=+month+(+1);if(month==12){new_year=+year+(+1);new_month=1;}
new_month=new_month<10?"0"+new_month:new_month;var nextMonth=new_month;var new_year=year;var new_month=+month-(+1);if(month==1){new_year=+year-(+1);new_month=12;}
new_month=new_month<10?"0"+new_month:new_month;var prevMonth=new_month;var embed_id=getDsmEmbedId(sk_ww_google_calendar);var search_term=localStorage.getItem("sk_google_cal_search_term");month=month.replace(/^0+/,'');month=month-1;var nextMonth=+month+(+1);var prevMonth=+month-(+1);var data=original_data;initializeFlatpickr_SkGoogleCalendar(sk_ww_google_calendar);var start_date_arr=new Array();data_storage=data.events;data_storage=searchData(data_storage,search_term);data_storage=applyDateFormat(data_storage,sk_ww_google_calendar);jQuery.each(data_storage,function(key,val){start_date_arr.push(val['start_date_raw']);});if(month==1){if((year%100!=0)&&(year%4==0)||(year%400==0)){FebNumberOfDays=29;}
else{FebNumberOfDays=28;}}
var monthNames=["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];var dayPerMonth=["31",FebNumberOfDays,"31","30","31","30","31","31","30","31","30","31"];var currentMonthName=monthNames[month];var currentMonthFirstDate=new Date(currentMonthName+' 1,'+year);var events_from_text=getDsmSetting(sk_ww_google_calendar,"events_from_text")+' ';var month_name_text=getFullMonthName(month);sk_ww_google_calendar.find('.sk_google_cal_view_label').text((events_from_text+getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),month_name_text)+" "+year).toLowerCase());var today=getTodayYmd();var currentMonthFirstDateDayIndex=currentMonthFirstDate.getDay();var dayNames=[getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Sun"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Mon"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Tue"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Wed"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Thu"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Fri"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Sat"),];if(getDsmSetting(sk_ww_google_calendar,"google_calendar_id")=="n2fr05kbjtc87v917vl5ng5ooo@group.calendar.google.com"){dayNames=[getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Mon"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Tue"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Wed"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Thu"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Fri"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Sat"),getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),"Sun"),];currentMonthFirstDateDayIndex-=1;}
var dayIndex2=currentMonthFirstDateDayIndex==-1?0:currentMonthFirstDateDayIndex;var numOfDays=dayPerMonth[month];while(currentMonthFirstDateDayIndex>0){htmlContent+="<td class='monthPre'></td>";currentMonthFirstDateDayIndex--;}
while(counter<=numOfDays){if(dayIndex2>6){dayIndex2=0;htmlContent+="</tr>";htmlContent+="<tr>";}
var sk_month_text=(month+1)>9?(month+1):"0"+(month+1);var sk_day_text=counter>9?counter:"0"+counter;var sk_current_day=year+"-"+sk_month_text+"-"+sk_day_text;if(today==sk_current_day){sk_day_text="<div class='sk_ww_google_calendar_today'>"+sk_day_text+"</div>";}
var timezone="Europe/London";htmlContent+="<td class='sk-cal-highlight-day' ";htmlContent+="data-fb-page-id='"+getDsmSetting(sk_ww_google_calendar,"fb_page_id")+"' data-date-selected='"+sk_current_day+"' ";htmlContent+="data-timezone='"+timezone+"' data-embed-id='"+embed_id+"'>";htmlContent+="<div class='cal-day-number'>"+sk_day_text+"</div>";var cal_day_event_count=0;var htmpContentTemp="";var eventsPopup="";var cal_day_count_display=[];jQuery.each(data_storage,function(key,val){if(!val['end_date_raw']){val['end_date_raw']=val['end_time_raw'];}
var dates_from_to_arr=[];if(val['start_date_raw'].indexOf("T")!=-1&&val['end_date_raw'].indexOf("T")!=-1){var endDate=new Date(val['end_date_raw'].split("T")[0]);var startDate=new Date(val['start_date_raw'].split("T")[0]);}
else{var endDate=new Date(val['end_date_raw']);var startDate=new Date(val['start_date_raw']);}
if(val['start_date_raw']==val['end_date_raw']){endDate.setDate(endDate.getDate()+1);}
while(startDate<endDate){const dateString=startDate.toISOString().slice(0,10);dates_from_to_arr.push(dateString);startDate.setDate(startDate.getDate()+1);}
let date_from_to_class="sk-dates-from-to";let event_name="&nbsp;";if(jQuery.inArray(sk_current_day,dates_from_to_arr)!=-1){let days_count=dates_from_to_arr.length;let days_count_attr="";if(event_name=="&nbsp;"){days_count_attr="";}
cal_day_event_count++;cal_day_count_display[sk_current_day]=cal_day_event_count;let event_last_date=dates_from_to_arr[dates_from_to_arr.length-1];let show_first_last=false;if(event_last_date==sk_current_day||sk_day_text==numOfDays){date_from_to_class="";show_first_last=true;}
if(dates_from_to_arr[0]==sk_current_day||sk_day_text==1){event_name=val['name'];show_first_last=true;days_count_attr="days-count='"+days_count+"' week-day-number='"+(dayIndex2)+"'";}
else if(dayIndex2==0){var newWeekStartDate=new Date(val['start_date_raw'].split("T")[0]);newWeekStartDate.setDate(counter);var newWeekEndDate=new Date(val['end_date_raw'].split("T")[0]);var diff=newWeekEndDate.getTime()-newWeekStartDate.getTime();var newDaysCount=Math.ceil(diff/(1000*3600*24))+1;var remainingDays=numOfDays-counter;if(newDaysCount>remainingDays){newDaysCount=remainingDays+1;}
days_count_attr="new-day='true' days-count='"+newDaysCount+"' week-day-number='"+(dayIndex2)+"'";}
if(getDsmSetting(sk_ww_google_calendar,'show_event_title_calendar')==1&&(date_from_to_class||show_first_last)){if(getDsmSetting(sk_ww_google_calendar,"enable_popup")==1){htmlContent+="<div "+days_count_attr+" class='sk_google_calendar_event_item_month_view sk-m-0 sk-cal-item "+date_from_to_class+" "+val['google_calendar_class']+"'>";}else{htmlContent+="<div "+days_count_attr+" onclick=\"window.open('"+val.html_link+"')\" class='sk-m-0 sk-cal-item "+date_from_to_class+" "+val['google_calendar_class']+"'>";}
htmlContent+="<div class='cal-day-event' ";htmlContent+="data-event-id='"+val['event_id']+"' ";htmlContent+="data-embed-id='"+embed_id+"'>";htmlContent+=event_name;htmlContent+="</div>";htmlContent+="<div class='sk_google_cal_pop_up_content_month_view sk_google_cal_white_popup mfp-hide'>";htmlContent+=getEventItemPopUpContent(val,sk_ww_google_calendar);htmlContent+="</div>";htmlContent+="</div>";}else{eventsPopup+=getEventItemPopUpContent(val,sk_ww_google_calendar);}}});if(getDsmSetting(sk_ww_google_calendar,'show_event_title_calendar')==0){htmpContentTemp="";jQuery.each(data_storage,function(key,val){if(!val['end_date_raw']){val['end_date_raw']=val['end_time_raw'];}
var dates_from_to_arr=[];if(val['start_date_raw'].indexOf("T")!=-1&&val['end_date_raw'].indexOf("T")!=-1){var endDate=new Date(val['end_date_raw'].split("T")[0]);var startDate=new Date(val['start_date_raw'].split("T")[0]);}
else{var endDate=new Date(val['end_date_raw']);var startDate=new Date(val['start_date_raw']);}
if(val['start_date_raw']==val['end_date_raw']){endDate.setDate(endDate.getDate()+1);}
while(startDate<endDate){const dateString=startDate.toISOString().slice(0,10);dates_from_to_arr.push(dateString);startDate.setDate(startDate.getDate()+1);}
let date_from_to_class="sk-dates-from-to";let event_name="&nbsp;";if(jQuery.inArray(sk_current_day,dates_from_to_arr)!=-1){let days_count=dates_from_to_arr.length;let days_count_attr="";console.log(event_name);let event_last_date=dates_from_to_arr[dates_from_to_arr.length-1];let show_first_last=false;if(event_last_date==sk_current_day||sk_day_text==numOfDays){date_from_to_class="";show_first_last=true;}
if(dates_from_to_arr[0]==sk_current_day||sk_day_text==1){event_name=dates_from_to_arr.length;event_name=cal_day_count_display[sk_current_day];show_first_last=true;days_count_attr="days-count='"+days_count+"'";}
else if(dayIndex2==0){var newWeekStartDate=new Date(val['start_date_raw'].split("T")[0]);newWeekStartDate.setDate(counter);var newWeekEndDate=new Date(val['end_date_raw'].split("T")[0]);var diff=newWeekEndDate.getTime()-newWeekStartDate.getTime();var newDaysCount=Math.ceil(diff/(1000*3600*24))+1;days_count_attr="new-day='true' days-count='"+newDaysCount+"'";}
if(date_from_to_class||show_first_last){if(getDsmSetting(sk_ww_google_calendar,"enable_popup")==1){htmpContentTemp+="<div "+days_count_attr+" class='sk_google_calendar_event_item_month_view sk-m-0 sk-cal-item "+date_from_to_class+" "+val['google_calendar_class']+"'>";}else{htmpContentTemp+="<div "+days_count_attr+" onclick=\"window.open('"+val.html_link+"')\"  class='sk-m-0 sk-cal-item "+date_from_to_class+" "+val['google_calendar_class']+"'>";}
htmpContentTemp+="<div class='cal-day-event' ";htmpContentTemp+="data-event-id='"+val['event_id']+"' ";htmpContentTemp+="data-embed-id='"+embed_id+"'>";htmpContentTemp+=event_name;htmpContentTemp+="</div>";htmpContentTemp+="<div class='sk_google_cal_pop_up_content_month_view sk_google_cal_white_popup mfp-hide'>";htmpContentTemp+=eventsPopup;htmpContentTemp+="</div>";htmpContentTemp+="</div>";htmlContent+=htmpContentTemp;}
return false;}});}
htmlContent+="</td>";dayIndex2++;counter++;}
var calendarBody="";calendarBody+="<div class='sk_ww_google_calendars_month_view_title'></div>";calendarBody+="<div class='sk-calendar-tbl-holder'>";calendarBody+="<table class='sk-calendar-tbl'>";calendarBody+="<tr class='dayNames'>";jQuery.each(dayNames,function(index,value){calendarBody+="<td>"+value+"</td>";});calendarBody+="</tr>";calendarBody+="<tr>";calendarBody+=getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),htmlContent);calendarBody+="</tr>";calendarBody+="</table>";calendarBody+="<div class='sk-cal-date-now display-none'>"+year+"-"+(month+1)+"-"+day+"</div>";calendarBody+="<div class='calendar-date-events sk_ww_google_calendars_white_pop_up mfp-hide'></div>";if(data&&data.user_info){calendarBody+=skGetBranding(sk_ww_google_calendar,data.user_info);}
sk_ww_google_calendar.find(".sk_google_cal_events_container").html(calendarBody);sk_ww_google_calendar.find('.sk_google_cal_container').show();var prev_month_text=getDsmSetting(sk_ww_google_calendar,'prev_month_text')?getDsmSetting(sk_ww_google_calendar,'prev_month_text'):"<i class='fa fa-chevron-left' aria-hidden='true'></i>";var next_month_text=getDsmSetting(sk_ww_google_calendar,'next_month_text')?getDsmSetting(sk_ww_google_calendar,'next_month_text'):"<i class='fa fa-chevron-right' aria-hidden='true'></i>";if(sk_ww_google_calendar.width()>=520){sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_prev_btn").html(prev_month_text);sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_next_btn").html(next_month_text);}
sk_ww_google_calendar.find(".sk_google_cal_month_tab").html("Month");sk_ww_google_calendar.find(".sk-calendar-tbl-holder table td, .sk-calendar-tbl-holder table th").css({'backgroundColor':getDsmSetting(sk_ww_google_calendar,"details_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"details_font_color")});sk_ww_google_calendar.find(".sk-cal-btn, .cal-day-event, .sk_ww_google_calendar_today, .sk_cal_day_event_count").css({'backgroundColor':getDsmSetting(sk_ww_google_calendar,"button_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});sk_ww_google_calendar.find(".cal-day-event a").css({'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});sk_ww_google_calendar.find(".sk-cal-empty-day, .sk-cal-highlight-day, .monthPre, .dayNames td").css({'border-bottom':'2px solid '+getDsmSetting(sk_ww_google_calendar,"button_bg_color")});sk_ww_google_calendar.find(".cal-day-event, .sk_cal_day_event_count").css({'border':'2px solid '+getDsmSetting(sk_ww_google_calendar,"cal_event_item_border_color")});if(sk_ww_google_calendar.width()<700||jQuery(document).width()<700){sk_ww_google_calendar.find('.sk-calendar-tbl-holder').css('overflow-x','scroll');}
applyCustomUi(jQuery,sk_ww_google_calendar);applyLayout(sk_ww_google_calendar);sk_ww_google_calendar.find('[days-count]').each(function(){let days_count=parseInt(jQuery(this).attr("days-count"));let week_day_number=parseInt(jQuery(this).attr("week-day-number"));let day_width=jQuery(".sk-cal-highlight-day").outerWidth();jQuery(this).css({'border-top-left-radius':'0px','border-top-right-radius':'0px',"position":"relative","padding-top":"18px"});if(days_count>1){jQuery(this).append(`<div class="cal-day-event cal-day-event-other-days">&nbsp;</div>`);}
jQuery(this).find(".cal-day-event-other-days").css({'margin':'0px','border':'none','border-bottom-left-radius':'0px','border-bottom-right-radius':'0px','backgroundColor':getDsmSetting(sk_ww_google_calendar,"button_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});jQuery(this).find(".cal-day-event-other-days").css({'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});var temp_days_count=7-week_day_number;if(days_count<temp_days_count){temp_days_count=days_count;}
let day_width_final=parseInt(day_width)*temp_days_count;jQuery(this).find(".cal-day-event-other-days").css({"top":"0px","width":day_width_final+"px","position":"absolute"})});sk_ww_google_calendar.find('.sk-cal-item:not([days-count])').each(function(){jQuery(this).find(".cal-day-event").css({"background-color":"transparent"});});sk_ww_google_calendar.find('.sk_google_calendar_event_item_month_view:not([days-count])').each(function(){jQuery(this).find(".cal-day-event").css({"background-color":"transparent"});});sk_ww_google_calendar.find('[new-day]').find(".cal-day-event").not(".cal-day-event-other-days").css({"background-color":"transparent"});}
function getFeedItem(val,sk_ww_google_calendar){var post_items="";event_counter++;post_items+="<div item='"+event_counter+"' class='grid-item-google-calendar grid-item-google-calendar-"+event_counter+" "+val.google_calendar_class+"'>";post_items+="<div class='sk_google_cal_grid_content'>";post_items+="<div class='post-content'>";post_items+="<div class='margin-zero'>";post_items+="<div class='sk-post-text'>";post_items+="<div class='sk-post-text-container'>";post_items+="<div class='sk_event_item_detail sk_event_name'>"+val.name+"</div>";post_items+="<div class='sk_event_item_detail sk_event_date'><span class='fa fa-calendar-o fa-calendar'></span> ";if(getDsmSetting(sk_ww_google_calendar,'show_day_text')==1&&val.start_day){post_items+=val.start_day+", ";}
post_items+="<span style='margin-right:13px;'>"+val.start_date+"</span>";if(val.start_time_display&&val.start_time!="12:00 am"&&val.start_time!="12:00 AM"){post_items+=" <span class='sk-event-str-time'><i class='fa fa-clock-o fa-clock'></i> "+val.start_time+"</span>";}
if(val.end_time_display&&getDsmSetting(sk_ww_google_calendar,"show_end_date_time")==1){post_items+=" - ";if(getDsmSetting(sk_ww_google_calendar,'show_day_text')==1&&val.end_day&&val.start_day!=val.end_day){post_items+=val.end_day!=""?val.end_day+", ":"";}
if(val.end_date!=val.start_date){post_items+="<span style='margin-right:13px;'>"+val.end_date+"</span>";}
if(val.end_time!="12:00 AM"&&val.end_time!="12:00 am"){post_items+=" <span class='sk-event-end-time'>  ";if(val.end_date!=val.start_date){post_items+=" <i class='fa fa-clock-o fa-clock'></i> ";}
post_items+=val.end_time;post_items+="</span>";}}
post_items+="</div>";if(val.recurrence){post_items+="<div class='sk_event_item_detail'>";post_items+="<span class='fa fa-repeat'></span> "+val.recurrence+" until "+val.until;post_items+="</div>";}
if(val.location){post_items+="<div class='sk_event_item_detail sk_event_time'><span class='fa fa-map-marker'></span> "+val.location+"</div>";}
if(val.description&&getDsmSetting(sk_ww_google_calendar,"show_description")==1){val.description=val.description.split(`\n`).join(`<br>`);post_items+="<div class='sk_event_item_detail sk_event_item_detail_description'>";post_items+=val.description;post_items+="</div>";}
if(getDsmSetting(sk_ww_google_calendar,"show_read_more_button")==1){if(getDsmSetting(sk_ww_google_calendar,"enable_popup")==1){post_items+="<div class='sk_event_item_detail'><button class='sk_google_cal_read_more_btn sk_google_cal_read_more_btn_popup'>"+getDsmSetting(sk_ww_google_calendar,"read_more_text")+"</button></div>";}
else{var read_more_btn_link=getDsmSetting(sk_ww_google_calendar,"read_more_default_link");if(!read_more_btn_link.trim()){read_more_btn_link=val.html_link;}
post_items+="<div class='sk_event_item_detail'><a target='_blank' href='"+read_more_btn_link+"' class='sk_google_cal_read_more_btn'>"+getDsmSetting(sk_ww_google_calendar,"read_more_text")+"</a></div>";}}
post_items+="</div>";post_items+="</div>";post_items+="<div class='sk_google_cal_pop_up_content sk_google_cal_white_popup mfp-hide'>";post_items+=getEventItemPopUpContent(val,sk_ww_google_calendar);post_items+="</div>";post_items+="</div>";post_items+="</div>";post_items+="</div>";post_items+="</div>";return getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),post_items);}
function loadGoogleCalendarFeedSk(sk_ww_google_calendar,selected_date){var post_items="";post_items+="<div class='sk_google_cal_container' style='display:none;'>";post_items+="<div class='sk_google_cal_control_bar'>";post_items+="<div class='sk_google_cal_date_picker_container'>";if(getDsmSetting(sk_ww_google_calendar,"show_date_buttons")==1){post_items+="<button class='sk_google_cal_date_picker_month_nav_btn sk_google_cal_date_picker_month_nav_prev_btn'>";post_items+="<i class='fa fa-chevron-left' aria-hidden='true'></i>";post_items+="</button>";}
var hide_class="hidden_el";if(getDsmSetting(sk_ww_google_calendar,"show_date_picker")==1){hide_class="";}
post_items+="<input class='"+hide_class+" sk_google_cal_date_picker_input' type='text' />";if(getDsmSetting(sk_ww_google_calendar,"show_date_buttons")==1){post_items+="<button class='sk_google_cal_date_picker_month_nav_btn sk_google_cal_date_picker_month_nav_next_btn'>";post_items+="<i class='fa fa-chevron-right' aria-hidden='true'></i>";post_items+="</button>";}
post_items+="</div>";if(getDsmSetting(sk_ww_google_calendar,"show_search_box")==1){var search_text=getDsmSetting(sk_ww_google_calendar,"search_text");search_text=search_text?search_text:"Search here...";post_items+="<div class='sk_google_cal_search_box_container'>";post_items+="<form class='sk_google_cal_search_box_form'>";post_items+="<input class='sk_google_cal_search_box_input' type='text' placeholder='"+search_text+"' />";post_items+="<i class='fa fa-search sk_google_cal_search_box_icon' aria-hidden='true'></i>";post_items+="</form>";post_items+="</div>";}
post_items+="<div class='sk_google_cal_tabs_container'>";if(getDsmSetting(sk_ww_google_calendar,"show_list_view")==1){post_items+="<button class='sk_google_cal_tab sk_google_cal_list_tab'>List</button>";}
if(getDsmSetting(sk_ww_google_calendar,"show_masonry_view")==1){post_items+="<button class='sk_google_cal_tab sk_google_cal_masonry_tab'>Masonry</button>";}
if(getDsmSetting(sk_ww_google_calendar,"show_grid_view")==1){post_items+="<button class='sk_google_cal_tab sk_google_cal_grid_tab'>Grid</button>";}
if(getDsmSetting(sk_ww_google_calendar,"show_slider_view")==1){post_items+="<button class='sk_google_cal_tab sk_google_cal_slider_tab'>Carousel</button>";}
if(getDsmSetting(sk_ww_google_calendar,"show_month_view")==1){post_items+="<button class='sk_google_cal_tab sk_google_cal_month_tab'>Month</button>";}
if(getDsmSetting(sk_ww_google_calendar,"show_export_calendar_button")==1){post_items+="<button class='sk_google_cal_tab tab_export_calendar'>Export Calendar</button>";}
post_items+="</div>";post_items+="</div>";var embed_id=getDsmEmbedId(sk_ww_google_calendar);if(getDsmSetting(sk_ww_google_calendar,"show_events_from_text")==1){post_items+="<div class='sk_google_cal_view_label'>Events from ...</div>";}
post_items+="<div class='sk_google_cal_events_container'></div>";post_items+="</div>";post_items+="</div>";post_items+="<div class='sk_google_cal_white_popup sk_ww_google_calendar_export_options mfp-hide'>";post_items+="<div class='sk_ww_google_calendar_export_info'>";post_items+=exportTranslation(sk_ww_google_calendar,embed_id);post_items+="</div>";post_items+="</div>";post_items=getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),post_items);sk_ww_google_calendar.append(post_items);if(original_data.settings){loadFeed(sk_ww_google_calendar);}
else{requestFeedData(sk_ww_google_calendar);}}
function loadFeed(sk_ww_google_calendar){if(original_data.user_info&&!widgetValidation(sk_ww_google_calendar,original_data)){return;}
var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);var selected_date=localStorage.getItem("sk_google_cal_selected_date");if(show_type=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}}
function requestFeedData(sk_ww_google_calendar){var embed_id=getDsmEmbedId(sk_ww_google_calendar);var json_url=app_file_server_url+embed_id+".json?nocache="+(new Date()).getTime();jQuery.getJSON(json_url,function(data){original_data=data;loadFeed(sk_ww_google_calendar);}).fail(function(e){generateSolutionMessage(sk_ww_google_calendar,embed_id);});}
function renderEventsSkGoogleCalendar(sk_ww_google_calendar){var selected_date=localStorage.getItem("sk_google_cal_selected_date");var embed_id=getDsmEmbedId(sk_ww_google_calendar);var search_term=localStorage.getItem("sk_google_cal_search_term");var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);var data=original_data;data_storage=data.events;data_storage=moderateData(data_storage,search_term,selected_date,sk_ww_google_calendar);data_storage=searchData(data_storage,search_term);data_storage=applyDateFormat(data_storage,sk_ww_google_calendar);data_storage=reformatData(data_storage,sk_ww_google_calendar);var post_items="";if(data.user_info&&data.user_info.show_feed==false){sk_ww_google_calendar.prepend(data.user_info.message);sk_ww_google_calendar.find('.loading-img').hide();sk_ww_google_calendar.find('.first_loading_animation').hide();sk_ww_google_calendar.find('.sk_fb_events_options').hide();}
else if(data.success==false){generateSolutionMessage(sk_ww_google_calendar,embed_id);}
else if(!data.events||(data.events&&data.events.error)){post_items+="<div class='sk_google_cal_no_events_found'>No upcoming events found.</div>";}
else{if(show_type=="slider"){post_items+=loadSliderLayout(sk_ww_google_calendar,data_storage);}
else{post_items+="<div class='sk_google_cal_events_holder'>";var event_items_html="";var enable_button=false;last_key=parseInt(getDsmSetting(sk_ww_google_calendar,'post_count'));for(var i=0;i<last_key;i++){if(typeof data_storage[i]!='undefined'){var item=data_storage[i];if(item.description){item.description=item.description.replace("<br><p","<p");}
event_items_html+=getFeedItem(item,sk_ww_google_calendar);}}
if(data_storage.length>last_key){enable_button=true;}
post_items+="</div>";sk_ww_google_calendar.find('.sk_google_cal_events_holder').empty();sk_ww_google_calendar.find('.sk_google_cal_temp_event_items_holder').empty();sk_ww_google_calendar.find('.sk_google_cal_temp_event_items_holder').html(event_items_html);if(enable_button&&getDsmSetting(sk_ww_google_calendar,'show_load_more_button')==1){post_items+="<div class='sk_google_calendar_end_button_container'>";post_items+="<button class='sk_google_calendar_load_more_btn'>"+getDsmSetting(sk_ww_google_calendar,'load_more_events_text')+"</button>";post_items+="</div>";}}}
if(data&&data.user_info){post_items+=skGetBranding(sk_ww_google_calendar,data.user_info);}
sk_ww_google_calendar.find(".sk_google_cal_events_container").html(post_items);sk_ww_google_calendar.find('.sk_google_cal_container').show();initializeFlatpickr_SkGoogleCalendar(sk_ww_google_calendar);var prev_month_text=getDsmSetting(sk_ww_google_calendar,'prev_month_text')?getDsmSetting(sk_ww_google_calendar,'prev_month_text'):"<i class='fa fa-chevron-left' aria-hidden='true'></i>";var next_month_text=getDsmSetting(sk_ww_google_calendar,'next_month_text')?getDsmSetting(sk_ww_google_calendar,'next_month_text'):"<i class='fa fa-chevron-right' aria-hidden='true'></i>";if(sk_ww_google_calendar.width()>=520){sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_prev_btn").html(prev_month_text);sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_next_btn").html(next_month_text);}
if(getDsmSetting(sk_ww_google_calendar,'google_calendar_id')=="credokirken.no_nj4b92qggbqv9ff8itjufq8vlg@group.calendar.google.com"){sk_ww_google_calendar.find(".sk_google_cal_view_label").text(getDsmSetting(sk_ww_google_calendar,"events_from_text")+" "+moment(selected_date).format('MMMM YYYY').toLowerCase());}
else{selected_date=getTodayMonthDayCommaYear(selected_date);selected_date=makeFullMonthName(selected_date);selected_date=getDayMonthTranslation(getDsmSetting(sk_ww_google_calendar,"translation"),selected_date);sk_ww_google_calendar.find(".sk_google_cal_view_label").text(getDsmSetting(sk_ww_google_calendar,"events_from_text")+" "+selected_date);}
if(show_type=='slider'){skSliderLayoutSettings(sk_ww_google_calendar);}
applyCustomUi(jQuery,sk_ww_google_calendar);applyLayout(sk_ww_google_calendar);makeLinkOpenNewTab();if(data.multiple_id_trigger_urls!==undefined&&data.multiple_id_trigger_urls.length>0){triggerMultipleId(sk_ww_google_calendar,data.multiple_id_trigger_urls);}
applyMasonry();fixMasonry();}
function triggerMultipleId(sk_ww_google_calendar,embed_ids){for(var i=0;i<embed_ids.length;i++){(function(index){setTimeout(function(){jQuery.getJSON(app_url+"embed/google-calendar/widget_events_json.php?embed_id="+embed_ids[index],function(data){});},i*1000);})(i);}}function applyMasonry(){if(jQuery('.sk_google_cal_events_holder').length){$grid=new Masonry('.sk_google_cal_events_holder',{itemSelector:'.grid-item-google-calendar',columnWidth:'.sk_google_cal_grid_content',percentPosition:true,transitionDuration:0});}}
function fixMasonry(){setTimeout(function(){applyMasonry();},500);setTimeout(function(){applyMasonry();},1000);setTimeout(function(){applyMasonry();},2000);setTimeout(function(){applyMasonry();},3000);setTimeout(function(){applyMasonry();},4000);setTimeout(function(){applyMasonry();},5000);setTimeout(function(){applyMasonry();},6000);setTimeout(function(){applyMasonry();},7000);setTimeout(function(){applyMasonry();},8000);setTimeout(function(){applyMasonry();},9000);setTimeout(function(){applyMasonry();},10000);}function loadSliderLayout(sk_ww_google_calendar,data_storage){var column_count=getDsmSetting(sk_ww_google_calendar,'column_count');column_count=parseInt(column_count);if(jQuery(document).width()<480){column_count=1;}
else if(jQuery(document).width()<750){column_count=column_count>2?2:column_count;}
var post_items="<div class='swiper-container swiper-layout-slider'>";post_items+="<button type='button' class='swiper-button-next ' style='pointer-events: all;'>";post_items+="<i class='sk-arrow sk-arrow-right'></i>";post_items+="</button>";post_items+="<button type='button' class='swiper-button-prev' style='pointer-events: all;'>";post_items+="<i class='sk-arrow sk-arrow-left'></i>";post_items+="</button>";post_items+="<div class='swiper-wrapper'>";var last_index=0;var data_slider=data_storage;var pages=Math.ceil(data_slider.length/column_count);for(var slide=1;slide<=pages;slide++){post_items+="<div class='swiper-slide' >";post_items+="<div class='sk_google_cal_events_holder' >";var slide_data=getPaginationResult(sk_ww_google_calendar,data_slider,slide,column_count);jQuery.each(slide_data,function(key,val){if(typeof val!='undefined')
post_items+=getFeedItem(val,sk_ww_google_calendar);});post_items+="</div>";post_items+="</div>";}
post_items+="</div>";post_items+="</div>";return post_items;}
function getPaginationResult(sk_ww_google_calendar,user_solutions,page,column_count){var start=0;var end=parseInt(column_count);var multiplicand=page-1;var return_user_solutions=[];if(page!=1){start=multiplicand*end;end=start+end;}
if((end-1)>user_solutions.length){end=user_solutions.length;}
for(var i=start;i<end;i++){return_user_solutions.push(user_solutions[i]);}
return return_user_solutions;}
function skSliderLayoutSettings(sk_ww_google_calendar){var autoplay=false;var loop=false;var is_auto_play=sk_ww_google_calendar.find('div.autoplay').text();if(is_auto_play==1){var delay=getDsmSetting(sk_ww_google_calendar,"delay")*1500;autoplay={delay:delay};loop=true;}
var swiper=new Swiper('.swiper-layout-slider.swiper-container',{loop:loop,autoplay:autoplay,navigation:{nextEl:'.swiper-button-next',prevEl:'.swiper-button-prev',},});}
function sliderLayoutMasonry(sk_ww_google_calendar){var sizer_width=33.3;var sk_ww_google_calendar_width=sk_ww_google_calendar.width();if(sk_ww_google_calendar_width<=320){sizer_width=100;}
else if(sk_ww_google_calendar_width<=481){sizer_width=100;}
else if(sk_ww_google_calendar_width<=720){sizer_width=50;}
else{if(getDsmSetting(sk_ww_google_calendar,"column_count")==1){sizer_width=100;}
if(getDsmSetting(sk_ww_google_calendar,"column_count")==2){sizer_width=50;}
else if(getDsmSetting(sk_ww_google_calendar,"column_count")==3){sizer_width=33.3;}
else if(getDsmSetting(sk_ww_google_calendar,"column_count")==4){sizer_width=24.95;}}
sk_ww_google_calendar.find('.grid-item-google-calendar').css({'width':sizer_width+'%'});var maxHeight=parseInt(getDsmSetting(sk_ww_google_calendar,"post_height"));console.log(sk_ww_google_calendar);sk_ww_google_calendar.find('.sk-post-text').height(maxHeight);skLayoutSliderArrowUI(sk_ww_google_calendar);}
function skLayoutSliderArrowUI(sk_ww_google_calendar){var arrow_background_color=getDsmSetting(sk_ww_google_calendar,"arrow_background_color");var arrow_color=getDsmSetting(sk_ww_google_calendar,"arrow_color");var arrow_opacity=getDsmSetting(sk_ww_google_calendar,"arrow_opacity");sk_ww_google_calendar.find(".swiper-button-prev i,.swiper-button-next i").mouseover(function(){jQuery(this).css({"opacity":"1","border-color":arrow_background_color,});}).mouseout(function(){jQuery(this).css({"border-color":arrow_color,"opacity":arrow_opacity});});sk_ww_google_calendar.find(".swiper-button-prev i,.swiper-button-next i").css({"border-color":arrow_color,"opacity":arrow_opacity,"color":arrow_color});sk_ww_google_calendar.find(".sk_google_cal_control_bar,.sk_google_cal_view_label").css({"width":88+"%","margin":"0 auto",});sk_ww_google_calendar.find(".swiper-button-spinner").css({"color":arrow_color});var feed_h=sk_ww_google_calendar.find('.sk_google_cal_events_holder').innerHeight();if(feed_h==null){feed_h=sk_ww_google_calendar.find('.sk_google_cal_events_holder').innerHeight();}
sk_ww_google_calendar.find(".swiper-wrapper,.swiper-slide").css({"height":feed_h+"px"});var feed_h_2=feed_h/2;sk_ww_google_calendar.find(".swiper-button-prev,.swiper-button-next").css({"top":feed_h_2+"px"});hoverContent(sk_ww_google_calendar);}
function applyLayout(sk_ww_google_calendar){var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);if(show_type=="slider"){sliderLayoutMasonry(sk_ww_google_calendar);}
else{var new_html=sk_ww_google_calendar.find('.sk_google_cal_temp_event_items_holder').html();sk_ww_google_calendar.find('.sk_google_cal_events_holder').html(new_html);}
var sk_google_calendar_width=sk_ww_google_calendar.width();if(show_type=="masonry"||show_type=="grid"){var column_count=getDsmSetting(sk_ww_google_calendar,"column_count");var sizer_width=33.3;var sk_ww_google_calendar_width=sk_ww_google_calendar.width();if(sk_ww_google_calendar_width<=320){sizer_width=100;}
else if(sk_ww_google_calendar_width<=481){sizer_width=100;}
else if(sk_ww_google_calendar_width<=720){sizer_width=50;}
else{if(column_count==1){sizer_width=100;}
if(column_count==2){sizer_width=50;}
else if(column_count==3){sizer_width=33.3;}
else if(column_count==4){sizer_width=24.95;}}
sk_ww_google_calendar.find('.grid-item-google-calendar').css({'width':sizer_width+'%'});if(show_type=="grid"||show_type=="slider"){var maxHeight=parseInt(getDsmSetting(sk_ww_google_calendar,"post_height"));maxHeight=isNaN(maxHeight)||maxHeight==0?300:maxHeight;jQuery(".sk_google_cal_container .sk-post-text").height(maxHeight);hoverContent(sk_ww_google_calendar);}}
else if(show_type=="list"){sk_ww_google_calendar.find('.grid-item-google-calendar').css({'width':'100%'});}
if(sk_google_calendar_width<=481){sk_ww_google_calendar.find('.sk_google_cal_search_box_container').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_tabs_container').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_list_tab').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_masonry_tab').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_grid_tab').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_slider_tab').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_month_tab').css({'width':'100%'});sk_ww_google_calendar.find('.sk_google_cal_date_picker_month_nav_next_btn').css({'margin-right':'0'});var sk_google_cal_control_bar_current_width=sk_ww_google_calendar.find(".sk_google_cal_control_bar").width();var sk_google_cal_date_picker_month_nav_prev_btn=sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_prev_btn").outerWidth(true);var sk_google_cal_date_picker_month_nav_next_btn=sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_next_btn").outerWidth(true);var sk_google_cal_date_picker_input_width=+sk_google_cal_control_bar_current_width-parseInt(parseInt(sk_google_cal_date_picker_month_nav_prev_btn)+parseInt(sk_google_cal_date_picker_month_nav_next_btn));sk_ww_google_calendar.find('.sk_google_cal_date_picker_input').css({'width':parseInt(sk_google_cal_date_picker_input_width)-1});}
else if(sk_google_calendar_width<=750){if(getDsmSetting(sk_ww_google_calendar,"show_list_view")==1){sk_ww_google_calendar.find('.sk_google_cal_list_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_masonry_view")==1){sk_ww_google_calendar.find('.sk_google_cal_masonry_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_grid_view")==1){sk_ww_google_calendar.find('.sk_google_cal_grid_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_slider_view")==1){sk_ww_google_calendar.find('.sk_google_cal_slider_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_month_view")==1){sk_ww_google_calendar.find('.sk_google_cal_month_tab').show();}}
else{if(getDsmSetting(sk_ww_google_calendar,"show_list_view")==1){sk_ww_google_calendar.find('.sk_google_cal_list_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_masonry_view")==1){sk_ww_google_calendar.find('.sk_google_cal_masonry_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_grid_view")==1){sk_ww_google_calendar.find('.sk_google_cal_grid_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_slider_view")==1){sk_ww_google_calendar.find('.sk_google_cal_slider_tab').show();}
if(getDsmSetting(sk_ww_google_calendar,"show_month_view")==1){sk_ww_google_calendar.find('.sk_google_cal_month_tab').show();}
sk_ww_google_calendar.find('.sk_google_cal_date_picker_input').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_search_box_container').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_tabs_container').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_list_tab').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_masonry_tab').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_grid_tab').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_slider_tab').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_month_tab').css({'width':'auto'});sk_ww_google_calendar.find('.sk_google_cal_date_picker_month_nav_next_btn').css({'margin-right':'10px'});}}
function hoverContent(sk_ww_google_calendar){if(jQuery(document).width()<480){sk_ww_google_calendar.find(".sk-post-text").css({"overflow-y":"auto","overflow-x":"hidden"})}
else{sk_ww_google_calendar.find(".sk-post-text").mouseover(function(){jQuery(this).css({"overflow-y":"auto","overflow-x":"hidden"});}).mouseout(function(){jQuery(this).css({"overflow-y":"hidden"});});sk_ww_google_calendar.find(".sk-post-text").css({'overflow':'hidden'});}}function showPopUp(jQuery,content_src,read_more_btn,sk_ww_google_calendar){if(typeof jQuery.magnificPopup==="undefined")
initManificPopupPlugin(jQuery);jQuery.magnificPopup.open({items:{src:content_src},'type':'inline',callbacks:{open:function(){replaceContentWithLinks(jQuery(jQuery('.mfp-content .sk-google-cal-event-description')[0]),sk_ww_google_calendar);applyPopUpColors(sk_ww_google_calendar);var popup_container=jQuery('.mfp-content');var popup_v1=jQuery('.nov-content');if(popup_v1.length>0){popup_container=popup_v1;popup_container.find('.sk_google_cal_white_popup').attr('style','display: block !important;')
var pop_up_bg_color=getDsmSetting(sk_ww_google_calendar,"pop_up_bg_color");popup_container.find('.sk_google_cal_white_popup').css('background',pop_up_bg_color)}
popup_container.find(".mfp-close, .nov-close").remove();popup_container.prepend('<button title="Close (Esc)" type="button" class="mfp-close" style="right: 0px;">×</button>');var post_html="";if(current_position>1){post_html+="<button class='prev_sk_google_calendar_event'>";post_html+="<i class='fa fa-chevron-left sk_prt_4px' aria-hidden='true'></i>";post_html+="</button>";}
if(current_position<jQuery('.sk_google_cal_events_container .grid-item-google-calendar').length){post_html+="<button class='next_sk_google_calendar_event'>";post_html+="<i class='fa fa-chevron-right sk_plt_4px' aria-hidden='true'></i>";post_html+="</button>";}
var offset=jQuery(document).width()-jQuery('.mfp-content').find(".sk_google_cal_white_popup").width();jQuery('.mfp-content').find(".mfp-close").css({"right":((offset/2)-40)+"px"});jQuery('.mfp-content').prepend(post_html);jQuery('.mfp-content').find(".next_sk_google_calendar_event").css({"right":((offset/2)-60)+"px"});jQuery('.mfp-content').find(".prev_sk_google_calendar_event").css({"left":((offset/2)-60)+"px"});if(jQuery(document).width()<=520){jQuery('.mfp-content').find(".mfp-close").css({"right":parseInt(jQuery('.mfp-content').find(".sk_google_cal_white_popup").css("marginRight"))+"px"});jQuery('.mfp-content').find(".next_sk_google_calendar_event").css({"right":parseInt(jQuery('.mfp-content').find(".sk_google_cal_white_popup").css("marginRight"))-15+"px"});jQuery('.mfp-content').find(".prev_sk_google_calendar_event").css({"left":parseInt(jQuery('.mfp-content').find(".sk_google_cal_white_popup").css("marginRight"))-15+"px"});}},close:function(){var popup_v1=jQuery('.nov-content');if(popup_v1.length>0){sk_ww_google_calendar.find('.sk_google_cal_pop_up_content_month_view').attr('style','display: none !important;')}}}});}
function getEventItemPopUpContent(val,sk_ww_google_calendar){var show_end_date_time=sk_ww_google_calendar.find('.show_end_date_time').text();var show_post_link=sk_ww_google_calendar.find('.show_post_link').text();var show_date_time_on_popup=getDsmSetting(sk_ww_google_calendar,"show_date_time_on_popup");var post_items="";post_items+="<div class='sk_event_item_detail sk_event_name'>"+val.name+"</div>";if(show_date_time_on_popup==1){post_items+="<div class='sk_event_item_detail sk_event_date'>";post_items+="<strong>Date and time:</strong> ";if(getDsmSetting(sk_ww_google_calendar,'show_day_text')==1&&val.start_day){post_items+=val.start_day+", ";}
if((val.start_time_raw&&val.end_time_raw)&&(val.start_time_raw==val.end_time_raw)){post_items+=val.start_date;post_items+=val.start_time!="12:00 AM"?", "+val.start_time:"";}
else{if(val.start_date){post_items+=val.start_date;post_items+=val.start_time!="12:00 AM"?", "+val.start_time:"";}
if(val.end_date&&show_end_date_time==1){post_items+=" - ";post_items+=val.start_date==val.end_date?"":moment(val.end_date).subtract(1,"days").format('MMMM DD, YYYY');+", ";post_items+=val.end_time!="12:00 AM"?val.end_time:"";}}
post_items+="</div>";}
if(val.recurrence){post_items+="<div class='sk_event_item_detail'>";post_items+="<strong>Recurrence: </strong> "+val.recurrence+" until "+val.until;post_items+="</div>";}
if(val.location){post_items+="<div class='sk_event_item_detail'><strong>Location: </strong> "+val.location+"</div>";}
if(val.description){val.description=val.description.split(`\n`).join(`<br>`);post_items+="<div class='sk_event_item_detail sk_event_description sk-google-cal-event-description'><strong>Description: </strong> "+val.description+"</div>";}
if(val.attachments){var attachments=JSON.parse(val.attachments);var attachments_text="";for(var i=0;i<attachments.length;i++){if(i==attachments.length-1){attachments_text=attachments_text+" <a class='sk-google-calendar-event-attachment' href='"+attachments[i]+"' target='_blank;'>"+attachments[i]+"</a>";}
else{attachments_text=attachments_text+" <a class='sk-google-calendar-event-attachment' href='"+attachments[i]+"' target='_blank;'>"+attachments[i]+"</a>";}}
post_items+="<div class='sk_event_item_detail sk_event_description'><strong>Attachments: </strong> "+attachments_text+"</div>";}
if(show_post_link==1){post_items+="<div class='sk_event_item_detail sk_event_time'><img class='sk-google-icon' src='"+app_url+"images/google_icon20.png'/> <a href=\""+val.html_link+"\" target='_blank'>"+getDsmSetting(sk_ww_google_calendar,"view_on_source_text")+"</a></div>";}
return post_items;}function makeLayoutResponsive(jQuery,sk_ww_google_calendar){var sk_google_cal_date_picker_container_width=sk_ww_google_calendar.find(".sk_google_cal_date_picker_container").width();var sk_cal_prev_month_btn_width=sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_prev_btn").outerWidth(true);var sk_cal_next_month_btn_width=sk_ww_google_calendar.find(".sk_google_cal_date_picker_month_nav_next_btn").outerWidth(true);var sk_ww_google_cal_date_picker_width=+sk_google_cal_date_picker_container_width-+(+sk_cal_prev_month_btn_width+(+sk_cal_next_month_btn_width));sk_ww_google_calendar.find('.sk_google_cal_date_picker_input').css({'width':sk_ww_google_cal_date_picker_width});var sk_google_cal_date_picker_container_w=sk_ww_google_calendar.find('.sk_google_cal_date_picker_container').width();var sk_google_cal_search_box_container_w=sk_ww_google_calendar.find('.sk_google_cal_search_box_container').width();var sk_google_cal_tabs_container_w=sk_ww_google_calendar.find('.sk_google_cal_tabs_container').width();var sk_google_cal_container_w=sk_ww_google_calendar.find('.sk_google_cal_container').width();sk_google_cal_date_picker_container_w=sk_google_cal_date_picker_container_w?sk_google_cal_date_picker_container_w:0;sk_google_cal_search_box_container_w=sk_google_cal_search_box_container_w?sk_google_cal_search_box_container_w:0;sk_google_cal_tabs_container_w=sk_google_cal_tabs_container_w?sk_google_cal_tabs_container_w:0;var t_w=parseInt(sk_google_cal_search_box_container_w)+parseInt(sk_google_cal_date_picker_container_w)+parseInt(sk_google_cal_tabs_container_w);}function applyCustomUi(jQuery,sk_ww_google_calendar){sk_ww_google_calendar.find(".loading-img").hide();var sk_ww_google_calendar_width=sk_ww_google_calendar.find('.sk_ww_google_calendar_width').text();var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);sk_ww_google_calendar.css({'width':'100%'});var sk_ww_google_calendar_width=sk_ww_google_calendar.innerWidth();sk_ww_google_calendar.css({'height':'auto'});var column_count=sk_ww_google_calendar.find('.column_count').text();var border_size=0;var background_color="#555555";var space_between_images=sk_ww_google_calendar.find('.space_between_images').text();var margin_between_images=parseFloat(space_between_images).toFixed(2)/2;var total_space_between_images=parseFloat(space_between_images).toFixed(2)*parseFloat(column_count);var pic_width=(parseFloat(sk_ww_google_calendar_width).toFixed(2)-parseFloat(total_space_between_images).toFixed(2))/parseFloat(column_count).toFixed(2);var sk_ig_all_posts_minus_spaces=parseFloat(sk_ww_google_calendar_width).toFixed(2)-parseFloat(total_space_between_images).toFixed(2);var bottom_button_container_width=parseFloat(sk_ww_google_calendar_width).toFixed(2)-(parseFloat(space_between_images).toFixed(2)*2);var bottom_button_width=parseFloat(sk_ww_google_calendar_width).toFixed(2)/parseFloat(2).toFixed(2);var sk_ww_google_calendar_width_minus_space_between_images=parseFloat(sk_ww_google_calendar_width).toFixed(2)-parseFloat(space_between_images).toFixed(2);var details_all_caps=getDsmSetting(sk_ww_google_calendar,"details_all_caps")==1?"uppercase":"none";sk_ww_google_calendar.css({'font-family':getDsmSetting(sk_ww_google_calendar,"font_family"),'width':sk_ww_google_calendar_width_minus_space_between_images,'background-color':getDsmSetting(sk_ww_google_calendar,"widget_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"details_font_color"),'font-size':getDsmSetting(sk_ww_google_calendar,"details_font_size")+'px','line-height':getDsmSetting(sk_ww_google_calendar,"details_line_height")+'px','letter-spacing':getDsmSetting(sk_ww_google_calendar,"letter_spacing")+'px','text-transform':details_all_caps});sk_ww_google_calendar.find(".cal-day-number").css({'font-size':getDsmSetting(sk_ww_google_calendar,"details_font_size")+'px'});var title_all_caps=getDsmSetting(sk_ww_google_calendar,"title_all_caps")==1?"uppercase":"none";sk_ww_google_calendar.find('.sk_event_name').css({'font-size':getDsmSetting(sk_ww_google_calendar,"title_font_size")+'px','line-height':getDsmSetting(sk_ww_google_calendar,"title_line_height")+'px','text-transform':title_all_caps});jQuery('.sk-pop-ig-post').css({'font-family':getDsmSetting(sk_ww_google_calendar,"font_family")});sk_ww_google_calendar.find('.sk_google_cal_grid_content,.sk_google_cal_no_events_found').css({'background-color':getDsmSetting(sk_ww_google_calendar,"details_bg_color")});sk_ww_google_calendar.find('.cal-day-event').css({'border':'none'})
jQuery(".sk_google_cal_read_more_btn, .sk_google_cal_read_more_btn_alt, .sk_google_calendar_load_more_btn").css({'background-color':getDsmSetting(sk_ww_google_calendar,"button_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_text_color"),'border-radius':getDsmSetting(sk_ww_google_calendar,"button_border_radius")+"px"});jQuery(".sk_google_cal_date_picker_month_nav_btn").css({'background-color':getDsmSetting(sk_ww_google_calendar,"button_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});jQuery(".sk_google_cal_read_more_btn, .sk_google_cal_read_more_btn_alt, .sk_google_calendar_load_more_btn, .sk_google_cal_date_picker_month_nav_btn").mouseover(function(){$(this).css({'background-color':getDsmSetting(sk_ww_google_calendar,"button_hover_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_hover_text_color")});}).mouseout(function(){$(this).css({'background-color':getDsmSetting(sk_ww_google_calendar,"button_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"button_text_color")});});jQuery(".sk_google_cal_date_picker_month_nav_prev_btn").css({'border-top-left-radius':getDsmSetting(sk_ww_google_calendar,"button_border_radius")+'px','border-bottom-left-radius':getDsmSetting(sk_ww_google_calendar,"button_border_radius")+'px'});jQuery(".sk_google_cal_date_picker_month_nav_next_btn").css({'border-top-right-radius':getDsmSetting(sk_ww_google_calendar,"button_border_radius")+'px','border-bottom-right-radius':getDsmSetting(sk_ww_google_calendar,"button_border_radius")+'px'});jQuery(".sk_google_cal_upcoming_events_tab, .sk_google_cal_past_events_tab").css({'border-radius':getDsmSetting(sk_ww_google_calendar,"tab_border_radius")+"px"});sk_ww_google_calendar.find('.sk_google_cal_tabs_container .sk_google_cal_tab:visible:first').css({'border-top-left-radius':getDsmSetting(sk_ww_google_calendar,"tab_border_radius")+'px','border-bottom-left-radius':getDsmSetting(sk_ww_google_calendar,"tab_border_radius")+'px'});sk_ww_google_calendar.find('.sk_google_cal_tabs_container .sk_google_cal_tab:visible:last').css({'border-top-right-radius':getDsmSetting(sk_ww_google_calendar,"tab_border_radius")+'px','border-bottom-right-radius':getDsmSetting(sk_ww_google_calendar,"tab_border_radius")+'px'});var item_content_padding=parseInt(getDsmSetting(sk_ww_google_calendar,"item_content_padding"));item_content_padding=isNaN(item_content_padding)?30:item_content_padding;sk_ww_google_calendar.find('.post-content').css({'padding':item_content_padding+'px',});sk_ww_google_calendar.find('.sk_google_cal_view_label').css({'color':getDsmSetting(sk_ww_google_calendar,"events_from_color"),});sk_ww_google_calendar.find('.sk_google_cal_tab').css({'background-color':'#888888','color':'#ffffff'});sk_ww_google_calendar.find('.sk_google_cal_tab').css({'background-color':getDsmSetting(sk_ww_google_calendar,"tab_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"tab_text_color")});sk_ww_google_calendar.find('.sk_google_cal_'+show_type+'_tab').css({'background-color':getDsmSetting(sk_ww_google_calendar,"active_tab_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"active_tab_text_color")});sk_ww_google_calendar.find('.sk_google_cal_control_bar').find('input,button').css({'font-family':getDsmSetting(sk_ww_google_calendar,"font_family")});sk_ww_google_calendar.find(".sk_event_item_detail_description a").css({'color':getDsmSetting(sk_ww_google_calendar,"details_link_color")});makeLayoutResponsive(jQuery,sk_ww_google_calendar);jQuery('.sk_powered_by a').css({'background-color':getDsmSetting(sk_ww_google_calendar,"details_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"details_font_color"),'font-size':getDsmSetting(sk_ww_google_calendar,"details_font_size"),});sk_ww_google_calendar.find('.sk-fb-event-item, .sk_powered_by').css({'margin-bottom':getDsmSetting(sk_ww_google_calendar,"space_between_events")+'px'});applyPopUpColors(sk_ww_google_calendar);if(sk_ww_google_calendar.find(".sk_google_cal_container").length>1){sk_ww_google_calendar.find(".sk_google_cal_container")[1].remove();}
setTimeout(function(){jQuery(".sk_google_cal_read_more_btn").removeClass("sk_google_cal_read_more_btn").addClass("sk_google_cal_read_more_btn_alt");},3000);jQuery('head').append('<style type="text/css">'+getDsmSetting(sk_ww_google_calendar,"custom_css")+'</style>');}
function applyPopUpColors(sk_ww_google_calendar){var pop_up_bg_color=getDsmSetting(sk_ww_google_calendar,"pop_up_bg_color");var pop_up_font_color=getDsmSetting(sk_ww_google_calendar,"pop_up_font_color");var pop_up_link_color=getDsmSetting(sk_ww_google_calendar,"pop_up_link_color");var item_content_padding=parseInt(getDsmSetting(sk_ww_google_calendar,"item_content_padding"));sk_ww_google_calendar.find('.sk_google_cal_white_popup').css({'background-color':getDsmSetting(sk_ww_google_calendar,"details_bg_color"),'color':getDsmSetting(sk_ww_google_calendar,"details_font_color"),'font-size':getDsmSetting(sk_ww_google_calendar,"details_font_size")+'px','line-height':getDsmSetting(sk_ww_google_calendar,"details_line_height")+'px','letter-spacing':getDsmSetting(sk_ww_google_calendar,"letter_spacing")+'px','text-transform':getDsmSetting(sk_ww_google_calendar,"details_all_caps")==1?"uppercase":"none",});sk_ww_google_calendar.find('.sk_google_cal_white_popup a').css({'color':pop_up_link_color,});}function main(){function loadSettingsData(sk_ww_google_calendar,json_settings_url,json_feed_url){fetch(json_feed_url,{method:'get'}).then(function(response){if(!response.ok){loadSettingsData(sk_ww_google_calendar,json_settings_url,json_settings_url)
return;}
response.json().then(function(data){var settings_data=data;original_data=data;if(data.settings){settings_data=data.settings;settings_data.type=34;}
if(!settings_data.type){loadSettingsData(sk_ww_google_calendar,json_settings_url,json_settings_url)
return;}
settings_data.type=34;var web_safe_fonts=["Inherit","Impact, Charcoal, sans-serif","'Palatino Linotype', 'Book Antiqua', Palatino, serif","Century Gothic, sans-serif","'Lucida Sans Unicode', 'Lucida Grande', sans-serif","Verdana, Geneva, sans-serif","Copperplate, 'Copperplate Gothic Light', fantasy","'Courier New', Courier, monospace","Georgia, Serif"];var is_font_included=web_safe_fonts.indexOf(settings_data.font_family);if(is_font_included<0){loadCssFile("https://fonts.googleapis.com/css?family="+settings_data.font_family);}
if(original_data.user_info&&!widgetValidation(sk_ww_google_calendar,original_data)){sk_ww_google_calendar.find('.loading-img').hide();sk_ww_google_calendar.find('.first_loading_animation').hide();}
else{var settings_html="";settings_html+="<div style='display:none;' class='display-none sk-settings'>";jQuery.each(settings_data,function(key,value){settings_html+="<div class='"+key+"'>"+value+"</div>";});settings_html+="<div class='sk_google_cal_temp_event_items_holder' style='display:none;'></div>";settings_html+="</div>";if(sk_ww_google_calendar.find('.sk-settings').length){}
else{sk_ww_google_calendar.prepend(settings_html);}
if(data.css){jQuery('head').append('<style type="text/css">'+data.css+'</style>');}
else{var sk_version=settings_data.sk_version?settings_data.sk_version:1.0;loadCssFile(app_url+"google-calendar/widget_css.php?v="+sk_version);}
settings_html="";var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,getDsmSetting(sk_ww_google_calendar,"default_view"));localStorage.setItem("sk_google_cal_search_term","");var date_today=getTodayYmd();localStorage.setItem("sk_google_cal_selected_date",date_today);var language_code="";if(settings_data.translation){var language_code=languageCode(settings_data.translation);}
if(language_code){loadScript("https://npmcdn.com/flatpickr@4.6.13/dist/l10n/"+language_code+".js",function(){loadGoogleCalendarFeedSk(sk_ww_google_calendar,date_today);});}
else{loadGoogleCalendarFeedSk(sk_ww_google_calendar,date_today);}}});}).catch(function(err){loadSettingsData(sk_ww_google_calendar,json_settings_url,json_settings_url);});}
jQuery(document).ready(function($){jQuery('.sk-ww-google-calendar').each(function(){var sk_ww_google_calendar=jQuery(this);var embed_id=getDsmEmbedId(sk_ww_google_calendar);var new_sk_ww_google_calendar_width=jQuery(window).height()+100;sk_ww_google_calendar.height(new_sk_ww_google_calendar_width);var json_settings_url=app_file_server_url.replace('feed/','')+"settings/"+embed_id+"/settings.json?nocache="+(new Date()).getTime();var json_feed_url=app_file_server_url+embed_id+".json?nocache="+(new Date()).getTime();loadSettingsData(sk_ww_google_calendar,json_settings_url,json_feed_url);});jQuery(document).on('submit','.sk_google_cal_search_box_form',function(){var sk_google_cal_search_box_input=jQuery(this).find(".sk_google_cal_search_box_input");var sk_ww_google_calendar=sk_google_cal_search_box_input.closest('.sk-ww-google-calendar');var search_term=sk_google_cal_search_box_input.val()!=undefined?sk_google_cal_search_box_input.val().toLowerCase():"";localStorage.setItem("sk_google_cal_search_term",search_term);var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);var selected_date=sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val();console.log('gdfgfdg')
if(show_type=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}
return false;});jQuery(document).on('change','.sk_google_cal_date_picker_input',function(){var sk_google_cal_date_picker_input=jQuery(this);var sk_ww_google_calendar=sk_google_cal_date_picker_input.closest('.sk-ww-google-calendar');var selected_date=sk_google_cal_date_picker_input.val();localStorage.setItem("sk_google_cal_selected_date",selected_date);var embed_id=getDsmEmbedId(sk_ww_google_calendar);var show_type=localStorage.getItem("sk_google_cal_show_type"+embed_id);if(show_type=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}});jQuery(document).on('click','.sk_google_cal_date_picker_month_nav_prev_btn',function(){var sk_google_cal_date_picker_month_nav_prev_btn=jQuery(this)
var sk_ww_google_calendar=sk_google_cal_date_picker_month_nav_prev_btn.closest('.sk-ww-google-calendar');var from=sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val().split("-");var year=from[0];var month=from[1];var day=from[2];var new_year=year;var new_month=+month-+1;if(month==1){new_year=+year-+1;new_month=12;}
new_month=new_month<10?"0"+new_month:new_month;var prev_month_formatted=new_year+'-'+new_month+'-01';localStorage.setItem("sk_google_cal_selected_date",prev_month_formatted);sk_ww_google_calendar.find('.sk_google_cal_date_picker_input').val(prev_month_formatted);initializeFlatpickr_SkGoogleCalendar(sk_ww_google_calendar,prev_month_formatted);var embed_id=getDsmEmbedId(sk_ww_google_calendar);if(localStorage.getItem("sk_google_cal_show_type"+embed_id)=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,prev_month_formatted);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}});jQuery(document).on('click','.sk_google_cal_date_picker_month_nav_next_btn',function(){var sk_google_cal_date_picker_month_nav_next_btn=jQuery(this)
var sk_ww_google_calendar=sk_google_cal_date_picker_month_nav_next_btn.closest('.sk-ww-google-calendar');var from=sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val().split("-");var year=from[0];var month=from[1];var day=from[2];var new_year=year;var new_month=+month+1;if(month==12){new_year=+year+1;new_month=1;}
new_month=new_month<10?"0"+new_month:new_month;var next_month_formatted=new_year+'-'+new_month+'-01';localStorage.setItem("sk_google_cal_selected_date",next_month_formatted);sk_ww_google_calendar.find('.sk_google_cal_date_picker_input').val(next_month_formatted);initializeFlatpickr_SkGoogleCalendar(sk_ww_google_calendar,next_month_formatted);var embed_id=getDsmEmbedId(sk_ww_google_calendar);if(localStorage.getItem("sk_google_cal_show_type"+embed_id)=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,next_month_formatted);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}});jQuery(document).on('keyup','.sk_google_cal_search_box_input',function(){var sk_google_cal_search_box_input=jQuery(this);var sk_ww_google_calendar=sk_google_cal_search_box_input.closest('.sk-ww-google-calendar');if(sk_google_cal_search_box_input.val()==""){localStorage.setItem("sk_google_cal_search_term","");var selected_date=sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val();var show_type=localStorage.getItem("sk_google_cal_show_type");if(localStorage.getItem("sk_google_cal_show_type")=="month"){renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date);}
else{renderEventsSkGoogleCalendar(sk_ww_google_calendar);}}});jQuery(document).on('click','.sk_google_cal_list_tab',function(){var sk_tab_clicked=jQuery(this);var sk_ww_google_calendar=sk_tab_clicked.closest('.sk-ww-google-calendar');var current_width=sk_tab_clicked.width();sk_tab_clicked.width(current_width);var sk_tab_clicked_html=sk_tab_clicked.html();sk_tab_clicked.html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,"list");renderEventsSkGoogleCalendar(sk_ww_google_calendar);sk_tab_clicked.html(sk_tab_clicked_html);});jQuery(document).on('click','.sk_google_cal_masonry_tab',function(){var sk_tab_clicked=jQuery(this);var sk_ww_google_calendar=sk_tab_clicked.closest('.sk-ww-google-calendar');var current_width=sk_tab_clicked.width();sk_tab_clicked.width(current_width);var sk_tab_clicked_html=sk_tab_clicked.html();sk_tab_clicked.html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,"masonry");renderEventsSkGoogleCalendar(sk_ww_google_calendar);sk_tab_clicked.html(sk_tab_clicked_html);});jQuery(document).on('click','.sk_google_cal_grid_tab',function(){var sk_tab_clicked=jQuery(this);var sk_ww_google_calendar=sk_tab_clicked.closest('.sk-ww-google-calendar');var current_width=sk_tab_clicked.width();sk_tab_clicked.width(current_width);var sk_tab_clicked_html=sk_tab_clicked.html();sk_tab_clicked.html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,"grid");renderEventsSkGoogleCalendar(sk_ww_google_calendar);sk_tab_clicked.html(sk_tab_clicked_html);});jQuery(document).on('click','.sk_google_cal_slider_tab',function(){var sk_tab_clicked=jQuery(this);var sk_ww_google_calendar=sk_tab_clicked.closest('.sk-ww-google-calendar');var current_width=sk_tab_clicked.width();sk_tab_clicked.width(current_width);var sk_tab_clicked_html=sk_tab_clicked.html();sk_tab_clicked.html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,"slider");renderEventsSkGoogleCalendar(sk_ww_google_calendar);sk_tab_clicked.html(sk_tab_clicked_html);});jQuery(document).on('click','.sk_google_cal_month_tab',function(){var sk_tab_clicked=jQuery(this);var sk_ww_google_calendar=sk_tab_clicked.closest('.sk-ww-google-calendar');var current_width=sk_tab_clicked.width();sk_tab_clicked.width(current_width);var selected_date=sk_ww_google_calendar.find(".sk_google_cal_date_picker_input").val();var sk_tab_clicked_html=sk_tab_clicked.html();sk_tab_clicked.html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");var embed_id=getDsmEmbedId(sk_ww_google_calendar);localStorage.setItem("sk_google_cal_show_type"+embed_id,"month");renderMonthViewSkGoogleCalendar(sk_ww_google_calendar,selected_date);sk_tab_clicked.html(sk_tab_clicked_html);});jQuery(document).on('click','.sk_google_calendar_load_more_btn',function(){var sk_google_calendar_load_more_btn=jQuery(this);var sk_ww_google_calendar=sk_google_calendar_load_more_btn.closest('.sk-ww-google-calendar');sk_google_calendar_load_more_btn.html("<i class='fa fa-spinner fa-pulse' aria-hidden='true'></i>");setTimeout(function(){var post_items="";var enable_button=false;var old_last_key=last_key;last_key=old_last_key+parseInt(getDsmSetting(sk_ww_google_calendar,'post_count'));for(var i=old_last_key;i<last_key;i++){if(typeof data_storage[i]!='undefined'){post_items+=getFeedItem(data_storage[i],sk_ww_google_calendar);}}
if(data_storage.length>last_key){enable_button=true;}
sk_ww_google_calendar.find('.sk_google_cal_temp_event_items_holder').append(post_items);sk_google_calendar_load_more_btn.html(getDsmSetting(sk_ww_google_calendar,'load_more_events_text'));applyLayout(sk_ww_google_calendar);if(!enable_button||getDsmSetting(sk_ww_google_calendar,'show_load_more_button')!=1){sk_google_calendar_load_more_btn.hide();}
else{sk_google_calendar_load_more_btn.show();}
jQuery(".sk_google_cal_read_more_btn_alt").addClass("sk_google_cal_read_more_btn");applyCustomUi(jQuery,sk_ww_google_calendar);fixMasonry();},100);});jQuery(document).on('click','.sk-ww-google-calendar .sk_google_cal_read_more_btn_popup',function(){var clicked_element=jQuery(this);var content_src=clicked_element.closest('.grid-item-google-calendar').find('.sk_google_cal_pop_up_content');current_position=clicked_element.closest('.grid-item-google-calendar').attr("item");var sk_ww_google_calendar=clicked_element.closest('.sk-ww-google-calendar');if(content_src.length>0){showPopUp(jQuery,content_src,clicked_element,sk_ww_google_calendar);}});jQuery(document).on('click','.sk-ww-google-calendar .sk_google_calendar_event_item_month_view',function(){var clicked_element=jQuery(this);var content_src=clicked_element.find('.sk_google_cal_pop_up_content_month_view');var sk_ww_google_calendar=clicked_element.closest('.sk-ww-google-calendar');if(content_src.length>0){showPopUp(jQuery,content_src,clicked_element,sk_ww_google_calendar);}});jQuery(document).on('click','.sk-ww-google-calendar .tab_export_calendar',function(){var read_more_btn=jQuery(this);var sk_ww_google_calendar=read_more_btn.closest('.sk-ww-google-calendar');var content_src=sk_ww_google_calendar.find(".sk_ww_google_calendar_export_options");if(content_src.length>0){showPopUp(jQuery,content_src,read_more_btn,sk_ww_google_calendar);}});jQuery(document).on('click','.sk_ww_google_calendars_export_tab',function(){var sk_ww_google_calendars_export_tab=jQuery(this);sk_ww_google_calendars_export_tab.closest('.container_sk_ww_google_calendars_export_tabs').find('.sk_ww_google_calendars_export_tab').removeClass('sk_ww_google_calendars_export_tab_active');sk_ww_google_calendars_export_tab.addClass('sk_ww_google_calendars_export_tab_active');var clicked_tab=sk_ww_google_calendars_export_tab.attr('data-clicked-tab');jQuery('.sk_ww_google_calendars_export_tab_content').hide();jQuery('.sk_export_to_'+clicked_tab).show();});jQuery(document).on('click','.btn-copy-google-cal-url',function(){var copy_button=jQuery(this);var copy_input=jQuery('#sk-google-cal-url-value');copyInput(copy_button,copy_input);});jQuery(document).on('click','.next_sk_google_calendar_event',function(){var clicked_element=jQuery(this);var sk_google_calendar_event=clicked_element.closest('.sk-ww-google-calendar');clicked_element.html("<i class='fa fa-spinner fa-pulse' aria-hidden='true'></i>");current_position++;var new_clicked_element=jQuery('.grid-item-google-calendar-'+current_position);var content_src=new_clicked_element.find('.sk_google_cal_white_popup').first();showPopUp(jQuery,content_src,new_clicked_element,sk_google_calendar_event);});jQuery(document).on('click','.prev_sk_google_calendar_event',function(){var clicked_element=jQuery(this);var sk_google_calendar_event=clicked_element.closest('.sk-ww-google-calendar');clicked_element.html("<i class='fa fa-spinner fa-pulse' aria-hidden='true'></i>");current_position--;var new_clicked_element=jQuery('.grid-item-google-calendar-'+current_position);var content_src=new_clicked_element.find('.sk_google_cal_white_popup').first();showPopUp(jQuery,content_src,new_clicked_element,sk_google_calendar_event);});});}function translateMonthName(eng_month_name,sk_fb_group_event){var month_name="";if(eng_month_name=="JAN"){month_name=getDsmSetting(sk_fb_group_event,"jan");}
else if(eng_month_name=="FEB"){month_name=getDsmSetting(sk_fb_group_event,"feb");}
else if(eng_month_name=="MAR"){month_name=getDsmSetting(sk_fb_group_event,"mar");}
else if(eng_month_name=="APR"){month_name=getDsmSetting(sk_fb_group_event,"apr");}
else if(eng_month_name=="MAY"){month_name=getDsmSetting(sk_fb_group_event,"may");}
else if(eng_month_name=="JUN"){month_name=getDsmSetting(sk_fb_group_event,"jun");}
else if(eng_month_name=="JUL"){month_name=getDsmSetting(sk_fb_group_event,"jul");}
else if(eng_month_name=="AUG"){month_name=getDsmSetting(sk_fb_group_event,"aug");}
else if(eng_month_name=="SEP"){month_name=getDsmSetting(sk_fb_group_event,"sep");}
else if(eng_month_name=="OCT"){month_name=getDsmSetting(sk_fb_group_event,"oct");}
else if(eng_month_name=="NOV"){month_name=getDsmSetting(sk_fb_group_event,"nov");}
else if(eng_month_name=="DEC"){month_name=getDsmSetting(sk_fb_group_event,"dec");}
return month_name;}
function translateDayName(eng_day_name,sk_fb_group_event){var day_name="";if(eng_day_name=="Sun"){day_name=getDsmSetting(sk_fb_group_event,"sun");}
else if(eng_day_name=="Mon"){day_name=getDsmSetting(sk_fb_group_event,"mon");}
else if(eng_day_name=="Tue"){day_name=getDsmSetting(sk_fb_group_event,"tue");}
else if(eng_day_name=="Wed"){day_name=getDsmSetting(sk_fb_group_event,"wed");}
else if(eng_day_name=="Thu"){day_name=getDsmSetting(sk_fb_group_event,"thu");}
else if(eng_day_name=="Fri"){day_name=getDsmSetting(sk_fb_group_event,"fri");}
else if(eng_day_name=="Sat"){day_name=getDsmSetting(sk_fb_group_event,"sat");}
return day_name;}
function getDayMonthTranslation(translation,replace){if(translation=="Croatian"){return getCroatianDayMonth(replace);}
else if(translation=="Italian"){return getItalianDayMonth(replace);}
else if(translation=="Spanish"){return getSpanishDayMonth(replace);}
else if(translation=="Norwegian"){return getNorwegianDayMonth(replace);}
else if(translation=="Filipino"){return getFilipinoDayMonth(replace);}
else if(translation=="French"){return getFrenchDayMonth(replace);}
else if(translation=="German"){return getGermanDayMonth(replace);}
else if(translation=="Polish"){return getPolishDayMonth(replace);}
else if(translation=="Russian"){return getRussianDayMonth(replace);}
else if(translation=="Faroese"){return getFaroeseDayMonth(replace);}
else if(translation=="Portuguese"){return getPortugueseDayMonth(replace);}
else if(translation=="Danish"){return getDanishDayMonth(replace);}
else if(translation=="Dutch"){return getDutchDayMonth(replace);}
else if(translation=="Swedish"){return getSwedishDayMonth(replace);}
else if(translation=="Hungarian"){return getHungarianDayMonth(replace);}
else if(translation=="Hebrew"){return getHebrewDayMonth(replace);}
else if(translation=="Finnish"){return getFinnishDayMonth(replace);}
else if(translation=="Slovak"){return getSlovakDayMonth(replace);}
else if(translation=="Turkish"){return getTurkishDayMonth(replace);}
else if(translation=="Estonian"){return getEstonianDayMonth(replace);}
else if(translation=="English - US"||translation=="English - UK"){return getEnglishDayMonth(replace);}
else{return replace;}}
function getEnglishDayMonth(replace){return replace;}
function getHebrewDayMonth(replace){replace=str_replace("Sunday","ראשון",replace)?str_replace("Sunday","ראשון",replace):replace;replace=str_replace("Monday","שני",replace)?str_replace("Monday","שני",replace):replace;replace=str_replace("Tuesday","שלישי",replace)?str_replace("Tuesday","שלישי",replace):replace;replace=str_replace("Wednesday","רביעי",replace)?str_replace("Wednesday","רביעי",replace):replace;replace=str_replace("Thursday","חמישי",replace)?str_replace("Thursday","חמישי",replace):replace;replace=str_replace("Friday","שישי",replace)?str_replace("Friday","שישי",replace):replace;replace=str_replace("Saturday","שבת",replace)?str_replace("Saturday","שבת",replace):replace;replace=str_replace("Sun","ראשון",replace)?str_replace("Sun","ראשון",replace):replace;replace=str_replace("Mon","שני",replace)?str_replace("Mon","שני",replace):replace;replace=str_replace("Tue","שלישי",replace)?str_replace("Tue","שלישי",replace):replace;replace=str_replace("Wed","רביעי",replace)?str_replace("Wed","רביעי",replace):replace;replace=str_replace("Thu","חמישי",replace)?str_replace("Thu","חמישי",replace):replace;replace=str_replace("Fri","שישי",replace)?str_replace("Fri","שישי",replace):replace;replace=str_replace("Sat","שבת",replace)?str_replace("Sat","שבת",replace):replace;replace=str_replace("January","בינואר",replace)?str_replace("January","בינואר",replace):replace;replace=str_replace("February","בפברואר",replace)?str_replace("February","בפברואר",replace):replace;replace=str_replace("March","במרץ",replace)?str_replace("March","במרץ",replace):replace;replace=str_replace("April","באפריל",replace)?str_replace("April","באפריל",replace):replace;replace=str_replace("May","במאי",replace)?str_replace("May","במאי",replace):replace;replace=str_replace("June","ביוני",replace)?str_replace("June","ביוני",replace):replace;replace=str_replace("July","ביולי",replace)?str_replace("July","ביולי",replace):replace;replace=str_replace("August","באוגוסט",replace)?str_replace("August","באוגוסט",replace):replace;replace=str_replace("September","בספטמבר",replace)?str_replace("September","בספטמבר",replace):replace;replace=str_replace("October","באוקטובר",replace)?str_replace("October","באוקטובר",replace):replace;replace=str_replace("November","בנובמבר",replace)?str_replace("November","בנובמבר",replace):replace;replace=str_replace("December","בדצמבר",replace)?str_replace("December","בדצמבר",replace):replace;replace=str_replace("Jan","בינואר",replace)?str_replace("Jan","בינואר",replace):replace;replace=str_replace("Feb","בפברואר",replace)?str_replace("Feb","בפברואר",replace):replace;replace=str_replace("Mar","במרץ",replace)?str_replace("Mar","במרץ",replace):replace;replace=str_replace("Apr","באפריל",replace)?str_replace("Apr","באפריל",replace):replace;replace=str_replace("May","במאי",replace)?str_replace("May","במאי",replace):replace;replace=str_replace("Jun","ביוני",replace)?str_replace("Jun","ביוני",replace):replace;replace=str_replace("Jul","ביולי",replace)?str_replace("Jul","ביולי",replace):replace;replace=str_replace("Aug","באוגוסט",replace)?str_replace("Aug","באוגוסט",replace):replace;replace=str_replace("Sep","בספטמבר",replace)?str_replace("Sep","בספטמבר",replace):replace;replace=str_replace("Oct","באוקטובר",replace)?str_replace("Oct","באוקטובר",replace):replace;replace=str_replace("Nov","בנובמבר",replace)?str_replace("Nov","בנובמבר",replace):replace;replace=str_replace("Dec","בדצמבר",replace)?str_replace("Dec","בדצמבר",replace):replace;replace=str_replace("reviews","ביקורות",replace)?str_replace("reviews","ביקורות",replace):replace;replace=str_replace("Address","כתובת",replace)?str_replace("Address","כתובת",replace):replace;replace=str_replace("Website","תר אינטרנט",replace)?str_replace("Website","אתר אינטרנט",replace):replace;replace=str_replace("Phone","טלפון",replace)?str_replace("Phone","טלפון",replace):replace;replace=str_replace("Business Hours","שעות פעילות",replace)?str_replace("Business Hours","שעות פעילות",replace):replace;replace=str_replace("Closed","סָגוּר",replace)?str_replace("Closed","סָגוּר",replace):replace;replace=str_replace("Coming soon","בקרוב",replace)?str_replace("Coming soon","בקרוב",replace):replace;replace=str_replace("PAST EVENT","אירוע עבר",replace)?str_replace("PAST EVENT","אירוע עבר",replace):replace;replace=str_replace("Search here...","חפש כאן...",replace)?str_replace("Search here...","חפש כאן...",replace):replace;return replace;}
function getHungarianDayMonth(replace){replace=str_replace("Sunday","Vas",replace)?str_replace("Sunday","Vas",replace):replace;replace=str_replace("Monday","Hét",replace)?str_replace("Monday","Hét",replace):replace;replace=str_replace("Tuesday","Kedd",replace)?str_replace("Tuesday","Kedd",replace):replace;replace=str_replace("Wednesday","Sze",replace)?str_replace("Wednesday","Sze",replace):replace;replace=str_replace("Thursday","Csü",replace)?str_replace("Thursday","Csü",replace):replace;replace=str_replace("Friday","Pén",replace)?str_replace("Friday","Pén",replace):replace;replace=str_replace("Saturday","Szo",replace)?str_replace("Saturday","Szo",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","February",replace)?str_replace("February","February",replace):replace;replace=str_replace("March","Már",replace)?str_replace("March","Már",replace):replace;replace=str_replace("April","Ápr",replace)?str_replace("April","Ápr",replace):replace;replace=str_replace("May","Máj",replace)?str_replace("May","Máj",replace):replace;replace=str_replace("June","Jún",replace)?str_replace("June","Jún",replace):replace;replace=str_replace("July","Júl",replace)?str_replace("July","Júl",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","Sze",replace)?str_replace("September","Sze",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","December",replace)?str_replace("December","December",replace):replace;replace=str_replace("reviews","vélemények",replace)?str_replace("reviews","vélemények",replace):replace;replace=str_replace("Address","Cím",replace)?str_replace("Address","Cím",replace):replace;replace=str_replace("Website","Weboldal",replace)?str_replace("Website","Weboldal",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Munka órák",replace)?str_replace("Business Hours","Munka órák",replace):replace;replace=str_replace("Closed","Zárva",replace)?str_replace("Closed","Zárva",replace):replace;replace=str_replace("Coming soon","Hamarosan",replace)?str_replace("Coming soon","Hamarosan",replace):replace;replace=str_replace("List","Lista",replace)?str_replace("List","Lista",replace):replace;replace=str_replace("Masonry","Kőművesség",replace)?str_replace("Masonry","Kőművesség",replace):replace;replace=str_replace("Grid","Rács",replace)?str_replace("Grid","Rács",replace):replace;replace=str_replace("Carousel","Körhinta",replace)?str_replace("Carousel","Körhinta",replace):replace;replace=str_replace("Month","Hónap",replace)?str_replace("Month","Hónap",replace):replace;replace=str_replace("Export Calendar","Naptár exportálása",replace)?str_replace("Export Calendar","Naptár exportálása",replace):replace;replace=str_replace("Search here...","Itt keress...",replace)?str_replace("Search here...","Itt keress...",replace):replace;return replace;}
function getSwedishDayMonth(replace){replace=str_replace("Sunday","Sön",replace)?str_replace("Sunday","Sön",replace):replace;replace=str_replace("Monday","Mån",replace)?str_replace("Monday","Mån",replace):replace;replace=str_replace("Tuesday","Tis",replace)?str_replace("Tuesday","Tis",replace):replace;replace=str_replace("Wednesday","Ons",replace)?str_replace("Wednesday","Ons",replace):replace;replace=str_replace("Thursday","Tors",replace)?str_replace("Thursday","Tors",replace):replace;replace=str_replace("Friday","Fre",replace)?str_replace("Friday","Fre",replace):replace;replace=str_replace("Saturday","Lör",replace)?str_replace("Saturday","Lör",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","February",replace)?str_replace("February","February",replace):replace;replace=str_replace("March","Mars",replace)?str_replace("March","Mars",replace):replace;replace=str_replace("April","April",replace)?str_replace("April","April",replace):replace;replace=str_replace("May","Maj",replace)?str_replace("May","Maj",replace):replace;replace=str_replace("June","June",replace)?str_replace("June","June",replace):replace;replace=str_replace("July","July",replace)?str_replace("July","July",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","September",replace)?str_replace("September","September",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","December",replace)?str_replace("December","December",replace):replace;replace=str_replace("reviews","recensioner",replace)?str_replace("reviews","recensioner",replace):replace;replace=str_replace("Address","Adress",replace)?str_replace("Address","Adress",replace):replace;replace=str_replace("Website","Hemsida",replace)?str_replace("Website","Hemsida",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Kontorstid",replace)?str_replace("Business Hours","Kontorstid",replace):replace;replace=str_replace("Closed","Stängd",replace)?str_replace("Closed","Stängd",replace):replace;replace=str_replace("Coming soon","Kommer snart",replace)?str_replace("Coming soon","Kommer snart",replace):replace;replace=str_replace("List","Lista",replace)?str_replace("List","Lista",replace):replace;replace=str_replace("Masonry","Murverk",replace)?str_replace("Masonry","Murverk",replace):replace;replace=str_replace("Grid","Rutnät",replace)?str_replace("Grid","Rutnät",replace):replace;replace=str_replace("Carousel","Karusell",replace)?str_replace("Carousel","Karusell",replace):replace;replace=str_replace("Month","Månad",replace)?str_replace("Month","Månad",replace):replace;replace=str_replace("Export Calendar","Exportera kalender",replace)?str_replace("Export Calendar","Exportera kalender",replace):replace;replace=str_replace("Search here...","Sök här...",replace)?str_replace("Search here...","Sök här...",replace):replace;return replace;}
function getNorwegianDayMonth(replace){replace=str_replace("Sunday","Søn",replace)?str_replace("Sunday","Søn",replace):replace;replace=str_replace("Monday","Man",replace)?str_replace("Monday","Man",replace):replace;replace=str_replace("Tuesday","Tir",replace)?str_replace("Tuesday","Tir",replace):replace;replace=str_replace("Wednesday","Ons",replace)?str_replace("Wednesday","Ons",replace):replace;replace=str_replace("Thursday","Tor",replace)?str_replace("Thursday","Tor",replace):replace;replace=str_replace("Friday","Fre",replace)?str_replace("Friday","Fre",replace):replace;replace=str_replace("Saturday","Lør",replace)?str_replace("Saturday","Lør",replace):replace;replace=str_replace("Sun","Søn",replace)?str_replace("Sun","Søn",replace):replace;replace=str_replace("Mon","Man",replace)?str_replace("Mon","Man",replace):replace;replace=str_replace("Tue","Tir",replace)?str_replace("Tue","Tir",replace):replace;replace=str_replace("Wed","Ons",replace)?str_replace("Wed","Ons",replace):replace;replace=str_replace("Thu","Tor",replace)?str_replace("Thu","Tor",replace):replace;replace=str_replace("Fri","Fre",replace)?str_replace("Fri","Fre",replace):replace;replace=str_replace("Sat","Lør",replace)?str_replace("Sat","Lør",replace):replace;replace=str_replace("January","Januar",replace)?str_replace("January","Januar",replace):replace;replace=str_replace("February","Februar",replace)?str_replace("February","Februar",replace):replace;replace=str_replace("March","Mars",replace)?str_replace("March","Mars",replace):replace;replace=str_replace("April","April",replace)?str_replace("April","April",replace):replace;replace=str_replace("May","Mai",replace)?str_replace("May","Mai",replace):replace;replace=str_replace("June","Juni",replace)?str_replace("June","Juni",replace):replace;replace=str_replace("July","Juli",replace)?str_replace("July","Juli",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","September",replace)?str_replace("September","September",replace):replace;replace=str_replace("October","Oktober",replace)?str_replace("October","Oktober",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","Desember",replace)?str_replace("December","Desember",replace):replace;replace=str_replace("reviews","anmeldelser",replace)?str_replace("reviews","anmeldelser",replace):replace;replace=str_replace("Address","Adresse",replace)?str_replace("Address","Adresse",replace):replace;replace=str_replace("Website","Nettsted",replace)?str_replace("Website","Nettsted",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Arbeidstid",replace)?str_replace("Business Hours","Arbeidstid",replace):replace;replace=str_replace("Closed","Stengt",replace)?str_replace("Closed","Stengt",replace):replace;replace=str_replace("Coming soon","Kommer snart",replace)?str_replace("Coming soon","Kommer snart",replace):replace;replace=str_replace("List","Liste",replace)?str_replace("List","Liste",replace):replace;replace=str_replace("Masonry","Murverk",replace)?str_replace("Masonry","Murverk",replace):replace;replace=str_replace("Grid","Nett",replace)?str_replace("Grid","Nett",replace):replace;replace=str_replace("Carousel","Karusell",replace)?str_replace("Carousel","Karusell",replace):replace;replace=str_replace("Month","Måned",replace)?str_replace("Month","Måned",replace):replace;replace=str_replace("Export Calendar","Eksporter kalender",replace)?str_replace("Export Calendar","Eksporter kalender",replace):replace;replace=str_replace("Search here...","Søk her...",replace)?str_replace("Search here...","Søk her...",replace):replace;replace=str_replace("Date and time","Dato og tid",replace)?str_replace("Date and time","Dato og tid",replace):replace;replace=str_replace("Location","Lokasjon",replace)?str_replace("Location","Lokasjon",replace):replace;replace=str_replace("Description","Beskrivelse",replace)?str_replace("Description","Beskrivelse",replace):replace;return replace;}
function getFilipinoDayMonth(replace){replace=str_replace("Sunday","Lin",replace)?str_replace("Sunday","Lin",replace):replace;replace=str_replace("Monday","Lun",replace)?str_replace("Monday","Lun",replace):replace;replace=str_replace("Tuesday","March",replace)?str_replace("Tuesday","March",replace):replace;replace=str_replace("Wednesday","Miy",replace)?str_replace("Wednesday","Miy",replace):replace;replace=str_replace("Thursday","Huw",replace)?str_replace("Thursday","Huw",replace):replace;replace=str_replace("Friday","Biy",replace)?str_replace("Friday","Biy",replace):replace;replace=str_replace("Saturday","Sab",replace)?str_replace("Saturday","Sab",replace):replace;replace=str_replace("January","Enero",replace)?str_replace("January","Enero",replace):replace;replace=str_replace("February","Pebrero",replace)?str_replace("February","Pebrero",replace):replace;replace=str_replace("March","Marso",replace)?str_replace("March","Marso",replace):replace;replace=str_replace("April","Abril",replace)?str_replace("April","Abril",replace):replace;replace=str_replace("May","Mayo",replace)?str_replace("May","Mayo",replace):replace;replace=str_replace("June","Hunyo",replace)?str_replace("June","Hunyo",replace):replace;replace=str_replace("July","Hulyo",replace)?str_replace("July","Hulyo",replace):replace;replace=str_replace("August","Agosto",replace)?str_replace("August","Agosto",replace):replace;replace=str_replace("September","Setyembre",replace)?str_replace("September","Setyembre",replace):replace;replace=str_replace("October","Oktubre",replace)?str_replace("October","Oktubre",replace):replace;replace=str_replace("November","Nobyembre",replace)?str_replace("November","Nobyembre",replace):replace;replace=str_replace("December","Desyembre",replace)?str_replace("December","Desyembre",replace):replace;replace=str_replace("reviews","mga pagsusuri",replace)?str_replace("reviews","mga pagsusuri",replace):replace;replace=str_replace("Address","Address",replace)?str_replace("Address","Address",replace):replace;replace=str_replace("Website","Website",replace)?str_replace("Website","Website",replace):replace;replace=str_replace("Phone","Telepono",replace)?str_replace("Phone","Telepono",replace):replace;replace=str_replace("Business Hours","Oras ng trabaho",replace)?str_replace("Business Hours","Oras ng trabaho",replace):replace;replace=str_replace("Closed","Sarado",replace)?str_replace("Closed","Sarado",replace):replace;replace=str_replace("Coming soon","Malapit na",replace)?str_replace("Coming soon","Malapit na",replace):replace;replace=str_replace("Search here...","Maghanap dito...",replace)?str_replace("Search here...","Maghanap dito...",replace):replace;return replace;}
function getCroatianDayMonth(replace){replace=str_replace("Sunday","Ned",replace)?str_replace("Sunday","Ned",replace):replace;replace=str_replace("Monday","Pon",replace)?str_replace("Monday","Pon",replace):replace;replace=str_replace("Tuesday","Uto",replace)?str_replace("Tuesday","Uto",replace):replace;replace=str_replace("Wednesday","Sri",replace)?str_replace("Wednesday","Sri",replace):replace;replace=str_replace("Thursday","Čet",replace)?str_replace("Thursday","Čet",replace):replace;replace=str_replace("Friday","Pet",replace)?str_replace("Friday","Pet",replace):replace;replace=str_replace("Saturday","Sub",replace)?str_replace("Saturday","Sub",replace):replace;replace=str_replace("January","Sij",replace)?str_replace("January","Sij",replace):replace;replace=str_replace("February","Velj",replace)?str_replace("February","Velj",replace):replace;replace=str_replace("March","Ozu",replace)?str_replace("March","Ozu",replace):replace;replace=str_replace("April","Tra",replace)?str_replace("April","Tra",replace):replace;replace=str_replace("May","Svi",replace)?str_replace("May","Svi",replace):replace;replace=str_replace("June","Lip",replace)?str_replace("June","Lip",replace):replace;replace=str_replace("July","Srp",replace)?str_replace("July","Srp",replace):replace;replace=str_replace("August","Kol",replace)?str_replace("August","Kol",replace):replace;replace=str_replace("September","Ruj",replace)?str_replace("September","Ruj",replace):replace;replace=str_replace("October","Lis",replace)?str_replace("October","Lis",replace):replace;replace=str_replace("November","Stu",replace)?str_replace("November","Stu",replace):replace;replace=str_replace("December","Pro",replace)?str_replace("December","Pro",replace):replace;replace=str_replace("month ago","prije mjeseca",replace)?str_replace("month ago","prije mjeseca",replace):replace;replace=str_replace("months ago","prije mjeseca",replace)?str_replace("months ago","prije mjeseca",replace):replace;replace=str_replace("day ago","prije dana",replace)?str_replace("day ago","prije dana",replace):replace;replace=str_replace("days ago","prije dana",replace)?str_replace("days ago","prije dana",replace):replace;replace=str_replace("year ago","prije godinu",replace)?str_replace("year ago","prije godinu",replace):replace;replace=str_replace("years ago","prije godinu",replace)?str_replace("years ago","prije godinu",replace):replace;replace=str_replace("Date and time","Datum i vrijeme",replace)?str_replace("Date and time","Datum i vrijeme",replace):replace;replace=str_replace("reviews","recenzije",replace)?str_replace("reviews","recenzije",replace):replace;replace=str_replace("Address","Adresa",replace)?str_replace("Address","Adresa",replace):replace;replace=str_replace("Website","Web stranica",replace)?str_replace("Website","Web stranica",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Radno vrijeme",replace)?str_replace("Business Hours","Radno vrijeme",replace):replace;replace=str_replace("Closed","Zatvoreno",replace)?str_replace("Closed","Zatvoreno",replace):replace;replace=str_replace("Coming soon","Dolazi uskoro",replace)?str_replace("Coming soon","Dolazi uskoro",replace):replace;replace=str_replace("List","Popis",replace)?str_replace("List","Popis",replace):replace;replace=str_replace("Masonry","Zidarstvo",replace)?str_replace("Masonry","Zidarstvo",replace):replace;replace=str_replace("Grid","Mreža",replace)?str_replace("Grid","Mreža",replace):replace;replace=str_replace("Carousel","Karusel",replace)?str_replace("Carousel","Karusel",replace):replace;replace=str_replace("Month","Mjesec",replace)?str_replace("Month","Mjesec",replace):replace;replace=str_replace("Export Calendar","Izvoz kalendara",replace)?str_replace("Export Calendar","Izvoz kalendara",replace):replace;replace=str_replace("Search here...","Traži ovdje...",replace)?str_replace("Search here...","Traži ovdje...",replace):replace;return replace;}
function getItalianDayMonth(replace){replace=str_replace("Sunday","Domenica",replace)?str_replace("Sunday","Domenica",replace):replace;replace=str_replace("Monday","Lunedi",replace)?str_replace("Monday","Lunedi",replace):replace;replace=str_replace("Tuesday","Martedì",replace)?str_replace("Tuesday","Martedì",replace):replace;replace=str_replace("Wednesday","Mercoledì",replace)?str_replace("Wednesday","Mercoledì",replace):replace;replace=str_replace("Thursday","Giovedì",replace)?str_replace("Thursday","Giovedì",replace):replace;replace=str_replace("Friday","Venerdì",replace)?str_replace("Friday","Venerdì",replace):replace;replace=str_replace("Saturday","Sabato",replace)?str_replace("Saturday","Sabato",replace):replace;replace=str_replace("January","Gennaio",replace)?str_replace("January","Gennaio",replace):replace;replace=str_replace("February","Febbraio",replace)?str_replace("February","Febbraio",replace):replace;replace=str_replace("March","Marzo",replace)?str_replace("March","Marzo",replace):replace;replace=str_replace("April","Aprile",replace)?str_replace("April","Aprile",replace):replace;replace=str_replace("May","Maggio",replace)?str_replace("May","Maggio",replace):replace;replace=str_replace("June","Giugno",replace)?str_replace("June","Giugno",replace):replace;replace=str_replace("July","Luglio",replace)?str_replace("July","Luglio",replace):replace;replace=str_replace("August","Agosto",replace)?str_replace("August","Agosto",replace):replace;replace=str_replace("September","Settembre",replace)?str_replace("September","Settembre",replace):replace;replace=str_replace("October","Ottobre",replace)?str_replace("October","Ottobre",replace):replace;replace=str_replace("November","Novembre",replace)?str_replace("November","Novembre",replace):replace;replace=str_replace("December","Dicembre",replace)?str_replace("December","Dicembre",replace):replace;replace=str_replace("month ago","un mese fa",replace)?str_replace("month ago","un mese fa",replace):replace;replace=str_replace("months ago","un mese fa",replace)?str_replace("months ago","un mese fa",replace):replace;replace=str_replace("day ago","giorno fa",replace)?str_replace("day ago","giorno fa",replace):replace;replace=str_replace("days ago","giorni fa",replace)?str_replace("days ago","giorni fa",replace):replace;replace=str_replace("year ago","anno fa",replace)?str_replace("year ago","anno fa",replace):replace;replace=str_replace("years ago","anno fa",replace)?str_replace("years ago","anno fa",replace):replace;replace=str_replace("week ago","settimana fa",replace)?str_replace("week ago","settimana fa",replace):replace;replace=str_replace("weeks ago","settimane fa",replace)?str_replace("weeks ago","settimane fa",replace):replace;replace=str_replace("Date and time","Data e ora",replace)?str_replace("Date and time","Data e ora",replace):replace;replace=str_replace("reviews","recensioni",replace)?str_replace("reviews","recensioni",replace):replace;replace=str_replace("Address","Indirizzo",replace)?str_replace("Address","Indirizzo",replace):replace;replace=str_replace("Website","Sito web",replace)?str_replace("Website","Sito web",replace):replace;replace=str_replace("Phone","Telefono",replace)?str_replace("Phone","Telefono",replace):replace;replace=str_replace("Business Hours","Ore di lavoro",replace)?str_replace("Business Hours","Ore di lavoro",replace):replace;replace=str_replace("Closed","Chiusa",replace)?str_replace("Closed","Chiusa",replace):replace;replace=str_replace("Coming soon","Prossimamente",replace)?str_replace("Coming soon","Prossimamente",replace):replace;replace=str_replace("second ago","un secondo fa",replace)?str_replace("second ago","un secondo fa",replace):replace;replace=str_replace("seconds ago","secondi fa",replace)?str_replace("seconds ago","secondi fa",replace):replace;replace=str_replace("minute ago","un minuto fa",replace)?str_replace("minute ago","un minuto fa",replace):replace;replace=str_replace("minutes ago","minuti fa",replace)?str_replace("minutes ago","minuti fa",replace):replace;replace=str_replace("hour ago","un'ora fa",replace)?str_replace("hour ago","un'ora fa",replace):replace;replace=str_replace("hours ago","ore fa",replace)?str_replace("hours ago","ore fa",replace):replace;replace=str_replace("month ago","un mese fa",replace)?str_replace("month ago","un mese fa",replace):replace;replace=str_replace("months ago","mesi fa",replace)?str_replace("months ago","mesi fa",replace):replace;replace=str_replace("day ago","un giorno fa",replace)?str_replace("day ago","un giorno fa",replace):replace;replace=str_replace("days ago","giorni fa",replace)?str_replace("days ago","giorni fa",replace):replace;replace=str_replace("year ago","un anno fa",replace)?str_replace("year ago","un anno fa",replace):replace;replace=str_replace("years ago","anni fa",replace)?str_replace("years ago","anni fa",replace):replace;replace=str_replace("Published","Pubblicato",replace)?str_replace("Published","Pubblicato",replace):replace;replace=str_replace("List","Elenco",replace)?str_replace("List","Elenco",replace):replace;replace=str_replace("Masonry","Opere murarie",replace)?str_replace("Masonry","Opere murarie",replace):replace;replace=str_replace("Grid","Griglia",replace)?str_replace("Grid","Griglia",replace):replace;replace=str_replace("Carousel","Giostra",replace)?str_replace("Carousel","Giostra",replace):replace;replace=str_replace("Month","Mese",replace)?str_replace("Month","Mese",replace):replace;replace=str_replace("Export Calendar","",replace)?str_replace("Export Calendar","Esporta calendario",replace):replace;replace=str_replace("Search here...","Cerca qui...",replace)?str_replace("Search here...","Cerca qui...",replace):replace;return replace;}
function getSpanishDayMonth(replace){replace=str_replace("Sunday","Dom",replace)?str_replace("Sunday","Dom",replace):replace;replace=str_replace("Monday","Lun",replace)?str_replace("Monday","Lun",replace):replace;replace=str_replace("Tuesday","Mar",replace)?str_replace("Tuesday","Mar",replace):replace;replace=str_replace("Wednesday","Mié",replace)?str_replace("Wednesday","Mié",replace):replace;replace=str_replace("Thursday","Jue",replace)?str_replace("Thursday","Jue",replace):replace;replace=str_replace("Friday","Vie",replace)?str_replace("Friday","Vie",replace):replace;replace=str_replace("Saturday","Sáb",replace)?str_replace("Saturday","Sáb",replace):replace;replace=str_replace("January","Enero",replace)?str_replace("January","Enero",replace):replace;replace=str_replace("February","Febrero",replace)?str_replace("February","Febrero",replace):replace;replace=str_replace("March","Marzo",replace)?str_replace("March","Marzo",replace):replace;replace=str_replace("April","Abril",replace)?str_replace("April","Abril",replace):replace;replace=str_replace("May","Mayo",replace)?str_replace("May","Mayo",replace):replace;replace=str_replace("June","Junio",replace)?str_replace("June","Junio",replace):replace;replace=str_replace("July","Julio",replace)?str_replace("July","Julio",replace):replace;replace=str_replace("August","Agosto",replace)?str_replace("August","Agosto",replace):replace;replace=str_replace("September","Septiembre",replace)?str_replace("September","Septiembre",replace):replace;replace=str_replace("October","Octubre",replace)?str_replace("October","Octubre",replace):replace;replace=str_replace("November","Noviembre",replace)?str_replace("November","Noviembre",replace):replace;replace=str_replace("December","Diciembre",replace)?str_replace("December","Diciembre",replace):replace;replace=str_replace("month ago","hace un mes",replace)?str_replace("month ago","hace un mes",replace):replace;replace=str_replace("months ago","hace un mes",replace)?str_replace("months ago","hace un mes",replace):replace;replace=str_replace("second ago","hace un segundo",replace)?str_replace("second ago","hace un segundo",replace):replace;replace=str_replace("seconds ago","segundos atrás",replace)?str_replace("seconds ago","segundos atrás",replace):replace;replace=str_replace("minute ago","hace un minuto",replace)?str_replace("minute ago","hace un minuto",replace):replace;replace=str_replace("minutes ago","minutos atrás",replace)?str_replace("minutes ago","minutos atrás",replace):replace;replace=str_replace("hour ago","hace una hora",replace)?str_replace("hour ago","hace una hora",replace):replace;replace=str_replace("hours ago","horas atrás",replace)?str_replace("hours ago","horas atrás",replace):replace;replace=str_replace("month ago","hace un mes",replace)?str_replace("month ago","hace un mes",replace):replace;replace=str_replace("months ago","meses atrás",replace)?str_replace("months ago","meses atrás",replace):replace;replace=str_replace("day ago","hace un día",replace)?str_replace("day ago","hace un día",replace):replace;replace=str_replace("days ago","días atrás",replace)?str_replace("days ago","días atrás",replace):replace;replace=str_replace("year ago","hace un año",replace)?str_replace("year ago","hace un año",replace):replace;replace=str_replace("years ago","años atrás",replace)?str_replace("years ago","años atrás",replace):replace;replace=str_replace("Date and time","Fecha y hora",replace)?str_replace("Date and time","Fecha y hora",replace):replace;replace=str_replace("reviews","reseñas",replace)?str_replace("reviews","reseñas",replace):replace;replace=str_replace("Address","Dirección",replace)?str_replace("Address","Dirección",replace):replace;replace=str_replace("Website","Sitio web",replace)?str_replace("Website","Sitio web",replace):replace;replace=str_replace("Phone","Teléfono",replace)?str_replace("Phone","Teléfono",replace):replace;replace=str_replace("Business Hours","Horas de trabajo",replace)?str_replace("Business Hours","Horas de trabajo",replace):replace;replace=str_replace("Closed","Cerrado",replace)?str_replace("Closed","Cerrado",replace):replace;replace=str_replace("Coming soon","Muy pronto",replace)?str_replace("Coming soon","Muy pronto",replace):replace;replace=str_replace("List","Lista",replace)?str_replace("List","Lista",replace):replace;replace=str_replace("Masonry","Albañilería",replace)?str_replace("Masonry","Albañilería",replace):replace;replace=str_replace("Grid","Red",replace)?str_replace("Grid","Red",replace):replace;replace=str_replace("Carousel","Carrusel",replace)?str_replace("Carousel","Carrusel",replace):replace;replace=str_replace("Month","Mes",replace)?str_replace("Month","Mes",replace):replace;replace=str_replace("Export Calendar","Calendario de exportación",replace)?str_replace("Export Calendar","Calendario de exportación",replace):replace;replace=str_replace("Search here...","Busca aquí...",replace)?str_replace("Search here...","Busca aquí...",replace):replace;return replace;}
function getFrenchDayMonth(replace){replace=str_replace("Sunday","dim",replace)?str_replace("Sunday","dim",replace):replace;replace=str_replace("Monday","lun",replace)?str_replace("Monday","lun",replace):replace;replace=str_replace("Tuesday","mar",replace)?str_replace("Tuesday","mar",replace):replace;replace=str_replace("Wednesday","mer",replace)?str_replace("Wednesday","mer",replace):replace;replace=str_replace("Thursday","jeu",replace)?str_replace("Thursday","jeu",replace):replace;replace=str_replace("Friday","ven",replace)?str_replace("Friday","ven",replace):replace;replace=str_replace("Saturday","sam",replace)?str_replace("Saturday","sam",replace):replace;replace=str_replace("Sun","Dim",replace)?str_replace("Sun","Dim",replace):replace;replace=str_replace("Mon","Lun",replace)?str_replace("Mon","Lun",replace):replace;replace=str_replace("Tue","Mar",replace)?str_replace("Tue","Mar",replace):replace;replace=str_replace("Wed","Mer",replace)?str_replace("Wed","Mer",replace):replace;replace=str_replace("Thu","Jeu",replace)?str_replace("Thu","Jeu",replace):replace;replace=str_replace("Fri","Ven",replace)?str_replace("Fri","Ven",replace):replace;replace=str_replace("Sat","Sam",replace)?str_replace("Sat","Sam",replace):replace;replace=str_replace("January","Janvier",replace)?str_replace("January","Janvier",replace):replace;replace=str_replace("February","Février",replace)?str_replace("February","Février",replace):replace;replace=str_replace("March","Mars",replace)?str_replace("March","Mars",replace):replace;replace=str_replace("April","Avr",replace)?str_replace("April","Avr",replace):replace;replace=str_replace("May","Mai",replace)?str_replace("May","Mai",replace):replace;replace=str_replace("June","Juin",replace)?str_replace("June","Juin",replace):replace;replace=str_replace("July","Jui",replace)?str_replace("July","Jui",replace):replace;replace=str_replace("August","Août",replace)?str_replace("August","Août",replace):replace;replace=str_replace("September","Septembre",replace)?str_replace("September","Septembre",replace):replace;replace=str_replace("October","Octobre",replace)?str_replace("October","Octobre",replace):replace;replace=str_replace("November","Novembre",replace)?str_replace("November","Novembre",replace):replace;replace=str_replace("December","Décembre",replace)?str_replace("December","Décembre",replace):replace;replace=str_replace("second ago","il y a une seconde",replace)?str_replace("second ago","il y a une seconde",replace):replace;replace=str_replace("seconds ago","il y a quelques secondes",replace)?str_replace("seconds ago","il y a quelques secondes",replace):replace;replace=str_replace("minute ago","il y a une minute",replace)?str_replace("minute ago","il y a une minute",replace):replace;replace=str_replace("minutes ago","il y a quelques minutes",replace)?str_replace("minutes ago","il y a quelques minutes",replace):replace;replace=str_replace("hour ago","il y a une heure",replace)?str_replace("hour ago","il y a une heure",replace):replace;replace=str_replace("hours ago","il y a quelques heures",replace)?str_replace("hours ago","il y a quelques heures",replace):replace;replace=str_replace("month ago","il y a un mois",replace)?str_replace("month ago","il y a un mois",replace):replace;replace=str_replace("months ago","il y a quelques mois",replace)?str_replace("months ago","il y a quelques mois",replace):replace;replace=str_replace("day ago","il y a un jour",replace)?str_replace("day ago","il y a un jour",replace):replace;replace=str_replace("days ago","il y a quelques jours",replace)?str_replace("days ago","il y a quelques jours",replace):replace;replace=str_replace("year ago","il y a un an",replace)?str_replace("year ago","il y a un an",replace):replace;replace=str_replace("years ago","il y a quelques années",replace)?str_replace("years ago","il y a quelques années",replace):replace;replace=str_replace("Date and time","Date et l'heure",replace)?str_replace("Date and time","Date et l'heure",replace):replace;replace=str_replace("reviews","Commentaires",replace)?str_replace("reviews","Commentaires",replace):replace;replace=str_replace("Address","Adresse",replace)?str_replace("Address","Adresse",replace):replace;replace=str_replace("Website","Site Internet",replace)?str_replace("Website","Site Internet",replace):replace;replace=str_replace("Phone","Téléphone fixe",replace)?str_replace("Phone","Téléphone fixe",replace):replace;replace=str_replace("Business Hours","Heures de travail",replace)?str_replace("Business Hours","Heures de travail",replace):replace;replace=str_replace("Closed","Fermée",replace)?str_replace("Closed","Fermée",replace):replace;replace=str_replace("Coming soon","Bientôt disponible",replace)?str_replace("Coming soon","Bientôt disponible",replace):replace;replace=str_replace("List","Liste",replace)?str_replace("List","Liste",replace):replace;replace=str_replace("Masonry","Maçonnerie",replace)?str_replace("Masonry","Maçonnerie",replace):replace;replace=str_replace("Grid","Grille",replace)?str_replace("Grid","Grille",replace):replace;replace=str_replace("Carousel","Carrousel",replace)?str_replace("Carousel","Carrousel",replace):replace;replace=str_replace("Month","Mois",replace)?str_replace("Month","Mois",replace):replace;replace=str_replace("Export Calendar","Exporter le calendrier",replace)?str_replace("Export Calendar","Exporter le calendrier",replace):replace;replace=str_replace("Search here...","Cherche ici...",replace)?str_replace("Search here...","Cherche ici...",replace):replace;return replace;}
function getDayMonthWeekWordTranslation(translation,replace){if(translation=="French"){return frenchDayMonthWeekTranslation(replace);}
if(translation=="Danish"){return danishDayMonthWeekTranslation(replace);}
else{return replace;}}
function frenchDayMonthWeekTranslation(replace){if(replace.indexOf("week")!==-1||replace.indexOf("w")!==-1){replace=str_replace("week"," semaine",replace)?str_replace("week"," semaine",replace):replace;replace=str_replace("w"," semaine",replace)?str_replace("w"," semaine",replace):replace;}else if(replace.indexOf("month")!==-1||replace.indexOf("m")!==-1||replace.indexOf("mo")!==-1){if(replace.indexOf("month")!==-1){replace=str_replace("month"," mois",replace)?str_replace("month"," mois",replace):replace;}else if(replace.indexOf("mo")!==-1){replace=str_replace("mo"," mois",replace)?str_replace("mo"," mois",replace):replace;}else if(replace.indexOf("mo")!==-1){replace=str_replace("m"," mois",replace)?str_replace("m"," mois",replace):replace;}
return replace;}else if(replace.indexOf("day")!==-1||replace.indexOf("d")!==-1){replace=str_replace("day"," jour",replace)?str_replace("day"," jour",replace):replace;replace=str_replace("d"," jour",replace)?str_replace("d"," jour",replace):replace;}else if(replace.indexOf("1yr")!==-1){replace=str_replace("yr"," année",replace)?str_replace("yr"," année",replace):replace;}else if(replace.indexOf("year")!==-1||replace.indexOf("y")!==-1){replace=str_replace("year"," années",replace)?str_replace("y"," années",replace):replace;replace=str_replace("y"," années",replace)?str_replace("y"," années",replace):replace;}
return parseInt(replace)>1?replace+'s':replace;}
function danishDayMonthWeekTranslation(replace){if(replace.indexOf("week")!==-1||replace.indexOf("w")!==-1){replace=str_replace("a week ago"," 1 uge siden",replace)?str_replace("a week ago"," 1 uge siden",replace):replace;if(replace.indexOf("week ago")!==-1){replace=str_replace("week ago"," uge siden",replace)?str_replace("week ago"," uge siden",replace):replace;}
else if(replace.indexOf("week")!==-1){replace=str_replace("week"," uge",replace)?str_replace("week"," uge",replace):replace;}
else{replace=str_replace("w"," uge",replace)?str_replace("w"," uge",replace):replace;}}
else if(replace.indexOf("month")!==-1||replace.indexOf("m")!==-1||replace.indexOf("mo")!==-1){replace=str_replace("a month ago"," 1 måned siden",replace)?str_replace("a month ago"," 1 måned siden",replace):replace;if(replace.indexOf("month ago")!==-1){replace=str_replace("month ago"," måned siden",replace)?str_replace("month ago"," måned siden",replace):replace;}
else if(replace.indexOf("months")!==-1){replace=str_replace("months ago"," måneder siden",replace)?str_replace("months ago"," måneder siden",replace):replace;}
else if(replace.indexOf("mo")!==-1){replace=str_replace("mo"," måned",replace)?str_replace("mo"," måned",replace):replace;}
else if(replace.indexOf("mo")!==-1){replace=str_replace("m"," måned",replace)?str_replace("m"," måned",replace):replace;}
return replace;}
else if(replace.indexOf("day")!==-1||replace.indexOf("d")!==-1){if(replace.indexOf("day")){replace=str_replace("a day ago"," 1 dag siden",replace)?str_replace("a day ago"," 1 dag siden",replace):replace;replace=str_replace("day ago"," dag siden",replace)?str_replace("day ago"," dag siden",replace):replace;replace=str_replace("days ago"," dage siden",replace)?str_replace("days ago"," dage siden",replace):replace;replace=str_replace("day"," dag",replace)?str_replace("day"," dag",replace):replace;}
else{replace=str_replace("d"," dag",replace)?str_replace("d"," dag",replace):replace;}}
else if(replace.indexOf("year")!==-1||replace.indexOf("y")!==-1){replace=str_replace("a year ago"," 1 år siden",replace)?str_replace("a year ago"," 1 år siden",replace):replace;if(replace.indexOf("years ago")!==-1){replace=str_replace("years ago"," år siden",replace)?str_replace("years ago"," år siden",replace):replace;}
else if(replace.indexOf("year")!==-1){replace=str_replace("year"," år",replace)?str_replace("y"," år",replace):replace;}
else{replace=str_replace("y"," år",replace)?str_replace("y"," år",replace):replace;}}
if(replace.includes('siden')){return replace;}
else{return parseInt(replace)>1?replace+'s':replace;}}
function getGermanDayMonth(replace){replace=str_replace("Sunday","So",replace)?str_replace("Sunday","So",replace):replace;replace=str_replace("Monday","Mo",replace)?str_replace("Monday","Mo",replace):replace;replace=str_replace("Tuesday","Di",replace)?str_replace("Tuesday","Di",replace):replace;replace=str_replace("Wednesday","Mi",replace)?str_replace("Wednesday","Mi",replace):replace;replace=str_replace("Thursday","Do",replace)?str_replace("Thursday","Do",replace):replace;replace=str_replace("Friday","Fr",replace)?str_replace("Friday","Fr",replace):replace;replace=str_replace("Saturday","Sa",replace)?str_replace("Saturday","Sa",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","February",replace)?str_replace("February","February",replace):replace;replace=str_replace("March","Mär",replace)?str_replace("March","Mär",replace):replace;replace=str_replace("April","April",replace)?str_replace("April","April",replace):replace;replace=str_replace("May","Mai",replace)?str_replace("May","Mai",replace):replace;replace=str_replace("June","June",replace)?str_replace("June","June",replace):replace;replace=str_replace("July","July",replace)?str_replace("July","July",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","September",replace)?str_replace("September","September",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","Dez",replace)?str_replace("December","Dez",replace):replace;replace=str_replace("second ago","vor einer Sekunde",replace)?str_replace("second ago","vor einer Sekunde",replace):replace;replace=str_replace("seconds ago","vor Sekunden",replace)?str_replace("seconds ago","vor Sekunden",replace):replace;replace=str_replace("minute ago","vor einer Minute",replace)?str_replace("minute ago","vor einer Minute",replace):replace;replace=str_replace("minutes ago","vor Minuten",replace)?str_replace("minutes ago","vor Minuten",replace):replace;replace=str_replace("hour ago","vor einer Stunde",replace)?str_replace("hour ago","vor einer Stunde",replace):replace;replace=str_replace("hours ago","vor Stunden",replace)?str_replace("hours ago","vor Stunden",replace):replace;replace=str_replace("month ago","vor einem Monat",replace)?str_replace("month ago","vor einem Monat",replace):replace;replace=str_replace("months ago","vor Monaten",replace)?str_replace("months ago","vor Monaten",replace):replace;replace=str_replace("day ago","vor einem Tag",replace)?str_replace("day ago","vor einem Tag",replace):replace;replace=str_replace("days ago","vor Tagen",replace)?str_replace("days ago","vor Tagen",replace):replace;replace=str_replace("year ago","vor einem Jahr",replace)?str_replace("year ago","vor einem Jahr",replace):replace;replace=str_replace("years ago","vor Jahren",replace)?str_replace("years ago","vor Jahren",replace):replace;replace=str_replace("an hour ago","Vor einem Stunde",replace)?str_replace("an hour ago","Vor einem Stunde",replace):replace;replace=str_replace("1 hour ago","Vor einem Stunde",replace)?str_replace("1 hour ago","Vor einem Stunde",replace):replace;replace=str_replace("hour ago","Vor einem Stunde",replace)?str_replace("hour ago","Vor einem Stunde",replace):replace;if(replace.includes("hours ago")){var quantity=parseInt(replace);if(quantity>0){replace="Vor "+quantity+" Stunden";}}
replace=str_replace("a month ago","Vor einem Monat",replace)?str_replace("a month ago","Vor einem Monat",replace):replace;if(replace.includes("months ago")){var quantity=parseInt(replace);if(quantity>0){replace="Vor "+quantity+" Monaten";}}
replace=str_replace("a day ago","Vor einem Tag",replace)?str_replace("a day ago","Vor einem Tag",replace):replace;if(replace.includes("days ago")){var quantity=parseInt(replace);if(quantity>0){replace="Vor "+quantity+" Tagen";}}
replace=str_replace("a year ago","1 Jahre zuvor",replace)?str_replace("a year ago","1 Jahre zuvor",replace):replace;replace=str_replace("years ago","Jahre zuvor",replace)?str_replace("years ago","Jahre zuvor",replace):replace;replace=str_replace("Date and time","Datum (und Uhrzeit",replace)?str_replace("Date and time","Datum (und Uhrzeit",replace):replace;replace=str_replace("reviews","Bewertungen",replace)?str_replace("reviews","Bewertungen",replace):replace;replace=str_replace("Address","Address",replace)?str_replace("Address","Address",replace):replace;replace=str_replace("Website","Webseite",replace)?str_replace("Website","Webseite",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Öffnungszeiten",replace)?str_replace("Business Hours","Öffnungszeiten",replace):replace;replace=str_replace("Closed","Geschlossen",replace)?str_replace("Closed","Geschlossen",replace):replace;replace=str_replace("Coming soon","Kommt bald",replace)?str_replace("Coming soon","Kommt bald",replace):replace;replace=str_replace("List","Aufführen",replace)?str_replace("List","Aufführen",replace):replace;replace=str_replace("Masonry","Mauerwerk",replace)?str_replace("Masonry","Mauerwerk",replace):replace;replace=str_replace("Grid","Netz",replace)?str_replace("Grid","Netz",replace):replace;replace=str_replace("Carousel","Karussell",replace)?str_replace("Carousel","Karussell",replace):replace;replace=str_replace("Month","Monat",replace)?str_replace("Month","Monat",replace):replace;replace=str_replace("Export Calendar","Kalender exportieren",replace)?str_replace("Export Calendar","Kalender exportieren",replace):replace;replace=str_replace("Search here...","Suche hier...",replace)?str_replace("Search here...","Suche hier...",replace):replace;return replace;}
function getPolishDayMonth(replace){replace=str_replace("January","Styczeń",replace)?str_replace("January","Styczeń",replace):replace;replace=str_replace("February","Luty",replace)?str_replace("February","Luty",replace):replace;replace=str_replace("March","Marzec",replace)?str_replace("March","Marzec",replace):replace;replace=str_replace("April","Kwiecień",replace)?str_replace("April","Kwiecień",replace):replace;replace=str_replace("May","Maj",replace)?str_replace("May","Maj",replace):replace;replace=str_replace("June","Czerwiec",replace)?str_replace("June","Czerwiec",replace):replace;replace=str_replace("July","Lipiec",replace)?str_replace("July","Lipiec",replace):replace;replace=str_replace("August","Sierpień",replace)?str_replace("August","Sierpień",replace):replace;replace=str_replace("September","Wrzesień",replace)?str_replace("September","Wrzesień",replace):replace;replace=str_replace("October","Październik",replace)?str_replace("October","Październik",replace):replace;replace=str_replace("November","Listopad",replace)?str_replace("November","Listopad",replace):replace;replace=str_replace("December","Grudzień",replace)?str_replace("December","Grudzień",replace):replace;replace=str_replace("Jan","Sty",replace)?str_replace("Jan","Sty",replace):replace;replace=str_replace("Feb","Lut",replace)?str_replace("Feb","Lut",replace):replace;replace=str_replace("Mar","Mar",replace)?str_replace("Mar","Mar",replace):replace;replace=str_replace("Apr","Kwi",replace)?str_replace("Apr","Kwi",replace):replace;replace=str_replace("May","Maj",replace)?str_replace("May","Maj",replace):replace;replace=str_replace("Jun","Cze",replace)?str_replace("Jun","Cze",replace):replace;replace=str_replace("Jul","Lip",replace)?str_replace("Jul","Lip",replace):replace;replace=str_replace("Aug","Sie",replace)?str_replace("Aug","Sie",replace):replace;replace=str_replace("Sep","Wrz",replace)?str_replace("Sep","Wrz",replace):replace;replace=str_replace("Oct","Paź",replace)?str_replace("Oct","Paź",replace):replace;replace=str_replace("Nov","Lis",replace)?str_replace("Nov","Lis",replace):replace;replace=str_replace("Dec","Gru",replace)?str_replace("Dec","Gru",replace):replace;replace=str_replace("Sun","Nie",replace)?str_replace("Sun","Nie",replace):replace;replace=str_replace("Mon","Pon",replace)?str_replace("Mon","Pon",replace):replace;replace=str_replace("Tue","Wto",replace)?str_replace("Tue","Wto",replace):replace;replace=str_replace("Wed","Śro",replace)?str_replace("Wed","Śro",replace):replace;replace=str_replace("Thu","Czw",replace)?str_replace("Thu","Czw",replace):replace;replace=str_replace("Fri","Pią",replace)?str_replace("Fri","Pią",replace):replace;replace=str_replace("Sat","Sob",replace)?str_replace("Sat","Sob",replace):replace;replace=str_replace("Sunday","Nie",replace)?str_replace("Sunday","Nie",replace):replace;replace=str_replace("Monday","Pon",replace)?str_replace("Monday","Pon",replace):replace;replace=str_replace("Tuesday","Wto",replace)?str_replace("Tuesday","Wto",replace):replace;replace=str_replace("Wednesday","Śro",replace)?str_replace("Wednesday","Śro",replace):replace;replace=str_replace("Thursday","Czw",replace)?str_replace("Thursday","Czw",replace):replace;replace=str_replace("Friday","Pią",replace)?str_replace("Friday","Pią",replace):replace;replace=str_replace("Saturday","Sob",replace)?str_replace("Saturday","Sob",replace):replace;replace=str_replace("month ago","miesiąc temu",replace)?str_replace("month ago","miesiąc temu",replace):replace;replace=str_replace("months ago","miesiąc temu",replace)?str_replace("months ago","miesiąc temu",replace):replace;replace=str_replace("Date and time","Data i godzina",replace)?str_replace("Date and time","Data i godzina",replace):replace;replace=str_replace("reviews","recenzje",replace)?str_replace("reviews","recenzje",replace):replace;replace=str_replace("Address","Adres zamieszkania",replace)?str_replace("Address","Adres zamieszkania",replace):replace;replace=str_replace("Website","Strona internetowa",replace)?str_replace("Website","Strona internetowa",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Godziny pracy",replace)?str_replace("Business Hours","Godziny pracy",replace):replace;replace=str_replace("Closed","Zamknięte",replace)?str_replace("Closed","Zamknięte",replace):replace;replace=str_replace("Coming soon","Wkrótce",replace)?str_replace("Coming soon","Wkrótce",replace):replace;replace=str_replace("List ","Lista ",replace)?str_replace("List ","Lista ",replace):replace;replace=str_replace("Masonry","Kamieniarstwo",replace)?str_replace("Masonry","Kamieniarstwo",replace):replace;replace=str_replace("Grid","Siatka",replace)?str_replace("Grid","Siatka",replace):replace;replace=str_replace("Carousel","Karuzela",replace)?str_replace("Carousel","Karuzela",replace):replace;replace=str_replace("Month","Miesiąc",replace)?str_replace("Month","Miesiąc",replace):replace;replace=str_replace("Export Calendar","Eksportuj kalendarz",replace)?str_replace("Export Calendar","Eksportuj kalendarz",replace):replace;replace=str_replace("Search here...","Szukaj tutaj...",replace)?str_replace("Search here...","Szukaj tutaj...",replace):replace;return replace;}
function getRussianDayMonth(replace){replace=str_replace("Sunday","ВС",replace)?str_replace("Sunday","ВС",replace):replace;replace=str_replace("Monday","ПН",replace)?str_replace("Monday","ПН",replace):replace;replace=str_replace("Tuesday","ВТ",replace)?str_replace("Tuesday","ВТ",replace):replace;replace=str_replace("Wednesday","СР",replace)?str_replace("Wednesday","СР",replace):replace;replace=str_replace("Thursday","ЧТ",replace)?str_replace("Thursday","ЧТ",replace):replace;replace=str_replace("Friday","ПТ",replace)?str_replace("Friday","ПТ",replace):replace;replace=str_replace("Saturday","СБ",replace)?str_replace("Saturday","СБ",replace):replace;replace=str_replace("January","Янв",replace)?str_replace("January","Янв",replace):replace;replace=str_replace("February","Февр",replace)?str_replace("February","Февр",replace):replace;replace=str_replace("March","Март",replace)?str_replace("March","Март",replace):replace;replace=str_replace("April","Апр",replace)?str_replace("April","Апр",replace):replace;replace=str_replace("May","Май",replace)?str_replace("May","Май",replace):replace;replace=str_replace("June","Июнь",replace)?str_replace("June","Июнь",replace):replace;replace=str_replace("July","Июль",replace)?str_replace("July","Июль",replace):replace;replace=str_replace("August","Авг",replace)?str_replace("August","Авг",replace):replace;replace=str_replace("September","Сент",replace)?str_replace("September","Сент",replace):replace;replace=str_replace("October","Октб",replace)?str_replace("October","Октб",replace):replace;replace=str_replace("November","Нояб",replace)?str_replace("November","Нояб",replace):replace;replace=str_replace("December","Дек",replace)?str_replace("December","Дек",replace):replace;replace=str_replace("month ago","месяц назад",replace)?str_replace("month ago","месяц назад",replace):replace;replace=str_replace("months ago","месяц назад",replace)?str_replace("months ago","месяц назад",replace):replace;replace=str_replace("Date and time","Дата и время",replace)?str_replace("Date and time","Дата и время",replace):replace;replace=str_replace("reviews","обзоры",replace)?str_replace("reviews","обзоры",replace):replace;replace=str_replace("Address","Адрес",replace)?str_replace("Address","Адрес",replace):replace;replace=str_replace("Website","Интернет сайт",replace)?str_replace("Website","Интернет сайт",replace):replace;replace=str_replace("Phone","Телефон",replace)?str_replace("Phone","Телефон",replace):replace;replace=str_replace("Business Hours","Рабочие часы",replace)?str_replace("Business Hours","Рабочие часы",replace):replace;replace=str_replace("Closed","Закрыто",replace)?str_replace("Closed","Закрыто",replace):replace;replace=str_replace("Coming soon","Скоро будет",replace)?str_replace("Coming soon","Скоро будет",replace):replace;replace=str_replace("List","Список",replace)?str_replace("List","Список",replace):replace;replace=str_replace("Masonry","Каменная кладка",replace)?str_replace("Masonry","Каменная кладка",replace):replace;replace=str_replace("Grid","Сетка",replace)?str_replace("Grid","Сетка",replace):replace;replace=str_replace("Carousel","Карусель",replace)?str_replace("Carousel","Карусель",replace):replace;replace=str_replace("Month","Месяц",replace)?str_replace("Month","Месяц",replace):replace;replace=str_replace("Export Calendar","Экспорт календаря",replace)?str_replace("Export Calendar","Экспорт календаря",replace):replace;replace=str_replace("Search here...","Поищи здесь...",replace)?str_replace("Search here...","Поищи здесь...",replace):replace;return replace;}
function getFaroeseDayMonth(replace){replace=str_replace("Sunday","Sunday",replace)?str_replace("Sunday","Sunday",replace):replace;replace=str_replace("Monday","Mán",replace)?str_replace("Monday","Mán",replace):replace;replace=str_replace("Tuesday","Týs",replace)?str_replace("Tuesday","Týs",replace):replace;replace=str_replace("Wednesday","Mik",replace)?str_replace("Wednesday","Mik",replace):replace;replace=str_replace("Thursday","Hós",replace)?str_replace("Thursday","Hós",replace):replace;replace=str_replace("Friday","Frí",replace)?str_replace("Friday","Frí",replace):replace;replace=str_replace("Saturday","Ley",replace)?str_replace("Saturday","Ley",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","February",replace)?str_replace("February","February",replace):replace;replace=str_replace("March","March",replace)?str_replace("March","March",replace):replace;replace=str_replace("April","April",replace)?str_replace("April","April",replace):replace;replace=str_replace("May","Mai",replace)?str_replace("May","Mai",replace):replace;replace=str_replace("June","June",replace)?str_replace("June","June",replace):replace;replace=str_replace("July","July",replace)?str_replace("July","July",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","September",replace)?str_replace("September","September",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","Des",replace)?str_replace("December","Des",replace):replace;return replace;}
function getPortugueseDayMonth(replace){replace=str_replace("Sunday","Dom",replace)?str_replace("Sunday","Dom",replace):replace;replace=str_replace("Monday","Seg",replace)?str_replace("Monday","Seg",replace):replace;replace=str_replace("Tuesday","Ter",replace)?str_replace("Tuesday","Ter",replace):replace;replace=str_replace("Wednesday","Qua",replace)?str_replace("Wednesday","Qua",replace):replace;replace=str_replace("Thursday","Qui",replace)?str_replace("Thursday","Qui",replace):replace;replace=str_replace("Friday","Sex",replace)?str_replace("Friday","Sex",replace):replace;replace=str_replace("Saturday","Sáb",replace)?str_replace("Saturday","Sáb",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","Fev",replace)?str_replace("February","Fev",replace):replace;replace=str_replace("March","March",replace)?str_replace("March","March",replace):replace;replace=str_replace("April","Abr",replace)?str_replace("April","Abr",replace):replace;replace=str_replace("May","Mai",replace)?str_replace("May","Mai",replace):replace;replace=str_replace("June","June",replace)?str_replace("June","June",replace):replace;replace=str_replace("July","July",replace)?str_replace("July","July",replace):replace;replace=str_replace("August","Ago",replace)?str_replace("August","Ago",replace):replace;replace=str_replace("September","Set",replace)?str_replace("September","Set",replace):replace;replace=str_replace("October","Out",replace)?str_replace("October","Out",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","Dez",replace)?str_replace("December","Dez",replace):replace;replace=str_replace("month ago","mês atrás",replace)?str_replace("month ago","mês atrás",replace):replace;replace=str_replace("months ago","mês atrás",replace)?str_replace("months ago","mês atrás",replace):replace;replace=str_replace("Date and time","Data e hora",replace)?str_replace("Date and time","Data e hora",replace):replace;replace=str_replace("reviews","avaliações",replace)?str_replace("reviews","avaliações",replace):replace;replace=str_replace("Address","Endereço",replace)?str_replace("Address","Endereço",replace):replace;replace=str_replace("Website","Local na rede Internet",replace)?str_replace("Website","Local na rede Internet",replace):replace;replace=str_replace("Phone","Telefone",replace)?str_replace("Phone","Telefone",replace):replace;replace=str_replace("Business Hours","Horário Comercial",replace)?str_replace("Business Hours","Horário Comercial",replace):replace;replace=str_replace("Closed","Fechadas",replace)?str_replace("Closed","Fechadas",replace):replace;replace=str_replace("Coming soon","Em breve",replace)?str_replace("Coming soon","Em breve",replace):replace;replace=str_replace("List","Lista",replace)?str_replace("List","Lista",replace):replace;replace=str_replace("Masonry","Alvenaria",replace)?str_replace("Masonry","Alvenaria",replace):replace;replace=str_replace("Grid","Grade",replace)?str_replace("Grid","Grade",replace):replace;replace=str_replace("Carousel","Carrossel",replace)?str_replace("Carousel","Carrossel",replace):replace;replace=str_replace("Month","Mês",replace)?str_replace("Month","Mês",replace):replace;replace=str_replace("Export Calendar","Exportar Calendário",replace)?str_replace("Export Calendar","Exportar Calendário",replace):replace;replace=str_replace("Search here...","Procure aqui...",replace)?str_replace("Search here...","Procure aqui...",replace):replace;return replace;}
function getDanishDayMonth(replace){replace=str_replace("Sunday","Søn",replace)?str_replace("Sunday","Søn",replace):replace;replace=str_replace("Monday","Man",replace)?str_replace("Monday","Man",replace):replace;replace=str_replace("Tuesday","Tir",replace)?str_replace("Tuesday","Tir",replace):replace;replace=str_replace("Wednesday","Ons",replace)?str_replace("Wednesday","Ons",replace):replace;replace=str_replace("Thursday","Tor",replace)?str_replace("Thursday","Tor",replace):replace;replace=str_replace("Friday","Fre",replace)?str_replace("Friday","Fre",replace):replace;replace=str_replace("Saturday","Lør",replace)?str_replace("Saturday","Lør",replace):replace;replace=str_replace("January","January",replace)?str_replace("January","January",replace):replace;replace=str_replace("February","February",replace)?str_replace("February","February",replace):replace;replace=str_replace("March","March",replace)?str_replace("March","March",replace):replace;replace=str_replace("April","April",replace)?str_replace("April","April",replace):replace;replace=str_replace("May","Maj",replace)?str_replace("May","Maj",replace):replace;replace=str_replace("June","June",replace)?str_replace("June","June",replace):replace;replace=str_replace("July","July",replace)?str_replace("July","July",replace):replace;replace=str_replace("August","August",replace)?str_replace("August","August",replace):replace;replace=str_replace("September","September",replace)?str_replace("September","Sep",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","November",replace)?str_replace("November","November",replace):replace;replace=str_replace("December","December",replace)?str_replace("December","December",replace):replace;replace=str_replace("month ago","måned siden",replace)?str_replace("month ago","måned siden",replace):replace;replace=str_replace("months ago","måned siden",replace)?str_replace("months ago","måned siden",replace):replace;replace=str_replace("Date and time","Dato og tid",replace)?str_replace("Date and time","Dato og tid",replace):replace;replace=str_replace("reviews","anmeldelser",replace)?str_replace("reviews","anmeldelser",replace):replace;replace=str_replace("Address","Adresse",replace)?str_replace("Address","Adresse",replace):replace;replace=str_replace("Website","Internet side",replace)?str_replace("Website","Internet side",replace):replace;replace=str_replace("Phone","telefon",replace)?str_replace("Phone","telefon",replace):replace;replace=str_replace("Business Hours","Arbejdstimer",replace)?str_replace("Business Hours","Arbejdstimer",replace):replace;replace=str_replace("Closed","Lukket",replace)?str_replace("Closed","Lukket",replace):replace;replace=str_replace("Coming soon","Kommer snart",replace)?str_replace("Coming soon","Kommer snart",replace):replace;replace=str_replace("List","Liste",replace)?str_replace("List","Liste",replace):replace;replace=str_replace("Masonry","Murværk",replace)?str_replace("Masonry","Murværk",replace):replace;replace=str_replace("Grid","Gitter",replace)?str_replace("Grid","Gitter",replace):replace;replace=str_replace("Carousel","Karrusel",replace)?str_replace("Carousel","Karrusel",replace):replace;replace=str_replace("Month","Måned",replace)?str_replace("Month","Måned",replace):replace;replace=str_replace("Export Calendar","Eksporter kalender",replace)?str_replace("Export Calendar","Eksporter kalender",replace):replace;replace=str_replace("Search here...","Søg her...",replace)?str_replace("Search here...","Søg her...",replace):replace;return replace;}
function getDutchDayMonth(replace){replace=str_replace("Sunday","Zondag",replace)?str_replace("Sunday","Zondag",replace):replace;replace=str_replace("Monday","Maandag",replace)?str_replace("Monday","Maandag",replace):replace;replace=str_replace("Tuesday","Dinsdag",replace)?str_replace("Tuesday","Dinsdag",replace):replace;replace=str_replace("Wednesday","Woensdag",replace)?str_replace("Wednesday","Woensdag",replace):replace;replace=str_replace("Thursday","Donderdag",replace)?str_replace("Thursday","Donderdag",replace):replace;replace=str_replace("Friday","Vrijdag",replace)?str_replace("Friday","Vrijdag",replace):replace;replace=str_replace("Saturday","Zaterdag",replace)?str_replace("Saturday","Zaterdag",replace):replace;replace=str_replace("January","januari",replace)?str_replace("January","januari",replace):replace;replace=str_replace("February","februari",replace)?str_replace("February","februari",replace):replace;replace=str_replace("March","maart",replace)?str_replace("March","maart",replace):replace;replace=str_replace("April","april",replace)?str_replace("April","april",replace):replace;replace=str_replace("May","mei",replace)?str_replace("May","mei",replace):replace;replace=str_replace("June","juni",replace)?str_replace("June","juni",replace):replace;replace=str_replace("July","juli",replace)?str_replace("July","juli",replace):replace;replace=str_replace("August","augustus",replace)?str_replace("August","augustus",replace):replace;replace=str_replace("September","september",replace)?str_replace("September","september",replace):replace;replace=str_replace("October","oktober",replace)?str_replace("October","oktober",replace):replace;replace=str_replace("November","november",replace)?str_replace("November","november",replace):replace;replace=str_replace("December","december",replace)?str_replace("December","december",replace):replace;replace=str_replace("month ago","maand geleden",replace)?str_replace("month ago","maand geleden",replace):replace;replace=str_replace("months ago","maand geleden",replace)?str_replace("months ago","maand geleden",replace):replace;replace=str_replace("Date and time","Datum en tijd",replace)?str_replace("Date and time","Datum en tijd",replace):replace;replace=str_replace("reviews","recensies",replace)?str_replace("reviews","recensies",replace):replace;replace=str_replace("Address","Adres",replace)?str_replace("Address","Adres",replace):replace;replace=str_replace("Website","Website",replace)?str_replace("Website","Website",replace):replace;replace=str_replace("Phone","Telefoon",replace)?str_replace("Phone","Telefoon",replace):replace;replace=str_replace("Business Hours","Openingstijden",replace)?str_replace("Business Hours","Openingstijden",replace):replace;replace=str_replace("Closed","Gesloten",replace)?str_replace("Closed","Gesloten",replace):replace;replace=str_replace("Coming soon","Binnenkort beschikbaar",replace)?str_replace("Coming soon","Binnenkort beschikbaar",replace):replace;replace=str_replace("List","Lijst",replace)?str_replace("List","Lijst",replace):replace;replace=str_replace("Masonry","Tegels",replace)?str_replace("Masonry","Tegels",replace):replace;replace=str_replace("Grid","Rooster",replace)?str_replace("Grid","Rooster",replace):replace;replace=str_replace("Carousel","Carrousel",replace)?str_replace("Carousel","Carrousel",replace):replace;replace=str_replace("Month","Maand",replace)?str_replace("Month","Maand",replace):replace;replace=str_replace("Export Calendar","Kalender exporteren",replace)?str_replace("Export Calendar","Kalender exporteren",replace):replace;replace=str_replace("Search here...","Zoek hier...",replace)?str_replace("Search here...","Zoek hier...",replace):replace;return replace;}
function getFinnishDayMonth(replace){replace=str_replace("Sunday","Sunnuntai",replace)?str_replace("Sunday","Sunnuntai",replace):replace;replace=str_replace("Monday","Maanantai",replace)?str_replace("Monday","Maanantai",replace):replace;replace=str_replace("Tuesday","Tiistai",replace)?str_replace("Tuesday","Tiistai",replace):replace;replace=str_replace("Wednesday","Keskiviikko",replace)?str_replace("Wednesday","Keskiviikko",replace):replace;replace=str_replace("Thursday","Torstai",replace)?str_replace("Thursday","Torstai",replace):replace;replace=str_replace("Friday","Perjantai",replace)?str_replace("Friday","Perjantai",replace):replace;replace=str_replace("Saturday","Lauantai",replace)?str_replace("Saturday","Lauantai",replace):replace;replace=str_replace("Sun","Su",replace)?str_replace("Sun","Su",replace):replace;replace=str_replace("Mon","Ma",replace)?str_replace("Mon","Ma",replace):replace;replace=str_replace("Tue","Ti",replace)?str_replace("Tue","Ti",replace):replace;replace=str_replace("Wed","Ke",replace)?str_replace("Wed","Ke",replace):replace;replace=str_replace("Thu","To",replace)?str_replace("Thu","To",replace):replace;replace=str_replace("Fri","Pe",replace)?str_replace("Fri","Pe",replace):replace;replace=str_replace("Sat","La",replace)?str_replace("Sat","La",replace):replace;replace=str_replace("January","Tammikuu",replace)?str_replace("January","Tammikuu",replace):replace;replace=str_replace("February","Helmikuu",replace)?str_replace("February","Helmikuu",replace):replace;replace=str_replace("March","Maaliskuu",replace)?str_replace("March","Maaliskuu",replace):replace;replace=str_replace("April","Huhtikuu",replace)?str_replace("April","Huhtikuu",replace):replace;replace=str_replace("May","Toukokuu",replace)?str_replace("May","Toukokuu",replace):replace;replace=str_replace("June","Kesäkuu",replace)?str_replace("June","Kesäkuu",replace):replace;replace=str_replace("July","Heinäkuu",replace)?str_replace("July","Heinäkuu",replace):replace;replace=str_replace("August","Elokuu",replace)?str_replace("August","Elokuu",replace):replace;replace=str_replace("September","Syyskuu",replace)?str_replace("September","Syyskuu",replace):replace;replace=str_replace("October","Lokakuu",replace)?str_replace("October","Lokakuu",replace):replace;replace=str_replace("November","Marraskuu",replace)?str_replace("November","Marraskuu",replace):replace;replace=str_replace("December","Joulukuu",replace)?str_replace("December","Joulukuu",replace):replace;replace=str_replace("month ago","kuukausi sitten",replace)?str_replace("month ago","kuukausi sitten",replace):replace;replace=str_replace("months ago","kuukausia sitten",replace)?str_replace("months ago","kuukausia sitten",replace):replace;replace=str_replace("Date and time","Päivämäärä ja aika",replace)?str_replace("Date and time","Päivämäärä ja aika",replace):replace;replace=str_replace("reviews","Arvostelut",replace)?str_replace("reviews","Arvostelut",replace):replace;replace=str_replace("Address","Osoite",replace)?str_replace("Address","Osoite",replace):replace;replace=str_replace("Website","Verkkosivusto",replace)?str_replace("Website","Verkkosivusto",replace):replace;replace=str_replace("Phone","Puhelin",replace)?str_replace("Phone","Puhelin",replace):replace;replace=str_replace("Business Hours","Pracovné hodiny",replace)?str_replace("Business Hours","Pracovné hodiny",replace):replace;replace=str_replace("Closed","Suljettu",replace)?str_replace("Closed","Suljettu",replace):replace;replace=str_replace("Coming soon","Tulossa pian",replace)?str_replace("Coming soon","Tulossa pian",replace):replace;replace=str_replace("List","Lista",replace)?str_replace("List","Lista",replace):replace;replace=str_replace("Masonry","Muuraus",replace)?str_replace("Masonry","Muuraus",replace):replace;replace=str_replace("Grid","Ruudukko",replace)?str_replace("Grid","Ruudukko",replace):replace;replace=str_replace("Carousel","Karuselli",replace)?str_replace("Carousel","Karuselli",replace):replace;replace=str_replace("Month","Kuukausi",replace)?str_replace("Month","Kuukausi",replace):replace;replace=str_replace("Export Calendar","Vie kalenteri",replace)?str_replace("Export Calendar","Vie kalenteri",replace):replace;replace=str_replace("Date and time","Päivämäärä ja aika",replace)?str_replace("Date and time","Päivämäärä ja aika",replace):replace;replace=str_replace("Location","Sijainti",replace)?str_replace("Location","Sijainti",replace):replace;replace=str_replace("Description","Kuvaus",replace)?str_replace("Description","Kuvaus",replace):replace;replace=str_replace("Search clearhere...","Etsi täältä...",replace)?str_replace("Search here...","Etsi täältä...",replace):replace;replace=str_replace("days ago","päivää sitten",replace)?str_replace("days ago","päivää sitten",replace):replace;replace=str_replace("day ago","päivä sitten",replace)?str_replace("day ago","päivä sitten",replace):replace;return replace;}
function getSlovakDayMonth(replace){replace=str_replace("Sunday","Nedeľa",replace)?str_replace("Sunday","Nedeľa",replace):replace;replace=str_replace("Monday","Pondelok",replace)?str_replace("Monday","Pondelok",replace):replace;replace=str_replace("Tuesday","Utorok",replace)?str_replace("Tuesday","Utorok",replace):replace;replace=str_replace("Wednesday","Streda",replace)?str_replace("Wednesday","Streda",replace):replace;replace=str_replace("Thursday","Štvrtok",replace)?str_replace("Thursday","Štvrtok",replace):replace;replace=str_replace("Friday","Piatok",replace)?str_replace("Friday","Piatok",replace):replace;replace=str_replace("Saturday","Sobota",replace)?str_replace("Saturday","Sobota",replace):replace;replace=str_replace("January","Jan",replace)?str_replace("January","Jan",replace):replace;replace=str_replace("February","Feb",replace)?str_replace("February","Feb",replace):replace;replace=str_replace("March","Mar",replace)?str_replace("March","Mar",replace):replace;replace=str_replace("April","Apr",replace)?str_replace("April","Apr",replace):replace;replace=str_replace("May","Máj",replace)?str_replace("May","Máj",replace):replace;replace=str_replace("June","Jún",replace)?str_replace("June","Jún",replace):replace;replace=str_replace("July","Júl",replace)?str_replace("July","Júl",replace):replace;replace=str_replace("August","Aug",replace)?str_replace("August","Aug",replace):replace;replace=str_replace("September","Sep",replace)?str_replace("September","Sep",replace):replace;replace=str_replace("October","Okt",replace)?str_replace("October","Okt",replace):replace;replace=str_replace("November","Nov",replace)?str_replace("November","Nov",replace):replace;replace=str_replace("December","Dec",replace)?str_replace("December","Dec",replace):replace;replace=str_replace("month ago","pred mesiacom",replace)?str_replace("month ago","pred mesiacom",replace):replace;replace=str_replace("months ago","pred mesiacom",replace)?str_replace("months ago","pred mesiacom",replace):replace;replace=str_replace("days ago","päivää sitten",replace)?str_replace("month ago","pred mesiacom",replace):replace;replace=str_replace("months ago","pred mesiacom",replace)?str_replace("months ago","pred mesiacom",replace):replace;replace=str_replace("Date and time","Dátum a čas",replace)?str_replace("Date and time","Dátum a čas",replace):replace;replace=str_replace("reviews","recenzie",replace)?str_replace("reviews","recenzie",replace):replace;replace=str_replace("Address","Adresa",replace)?str_replace("Address","Adresa",replace):replace;replace=str_replace("Website","Webová stránka",replace)?str_replace("Website","Webová stránka",replace):replace;replace=str_replace("Phone","Telefón",replace)?str_replace("Phone","Telefón",replace):replace;replace=str_replace("Business Hours","Pracovné hodiny",replace)?str_replace("Business Hours","Pracovné hodiny",replace):replace;replace=str_replace("Closed","ZATVORENÉ",replace)?str_replace("Closed","ZATVORENÉ",replace):replace;replace=str_replace("Coming soon","Už čoskoro",replace)?str_replace("Coming soon","Už čoskoro",replace):replace;replace=str_replace("List","Zoznam",replace)?str_replace("List","Zoznam",replace):replace;replace=str_replace("Masonry","Murárstvo",replace)?str_replace("Masonry","Murárstvo",replace):replace;replace=str_replace("Grid","Mriežka",replace)?str_replace("Grid","Mriežka",replace):replace;replace=str_replace("Carousel","Kolotoč",replace)?str_replace("Carousel","Kolotoč",replace):replace;replace=str_replace("Month","Mesiac",replace)?str_replace("Month","Mesiac",replace):replace;replace=str_replace("Export Calendar","Exportovať kalendár",replace)?str_replace("Export Calendar","Exportovať kalendár",replace):replace;replace=str_replace("Search here...","Hľadaj tu...",replace)?str_replace("Search here...","Hľadaj tu...",replace):replace;return replace;}
function getTurkishDayMonth(replace){replace=str_replace("Sunday","Pazar",replace)?str_replace("Sunday","Pazar",replace):replace;replace=str_replace("Monday","Pazartesi",replace)?str_replace("Monday","Pazartesi",replace):replace;replace=str_replace("Tuesday","Salı",replace)?str_replace("Tuesday","Salı",replace):replace;replace=str_replace("Wednesday","Çarşamba",replace)?str_replace("Wednesday","Çarşamba",replace):replace;replace=str_replace("Thursday","Perşembe",replace)?str_replace("Thursday","Perşembe",replace):replace;replace=str_replace("Friday","Cuma",replace)?str_replace("Friday","Cuma",replace):replace;replace=str_replace("Saturday","Cumartesi",replace)?str_replace("Saturday","Cumartesi",replace):replace;replace=str_replace("January","Ocak",replace)?str_replace("January","Ocak",replace):replace;replace=str_replace("February","Şubat",replace)?str_replace("February","Şubat",replace):replace;replace=str_replace("March","Mart",replace)?str_replace("March","Mart",replace):replace;replace=str_replace("April","Nisan",replace)?str_replace("April","Nisan",replace):replace;replace=str_replace("May","Mayıs",replace)?str_replace("May","Mayıs",replace):replace;replace=str_replace("June","Haziran",replace)?str_replace("June","Haziran",replace):replace;replace=str_replace("July","Temmuz",replace)?str_replace("July","Temmuz",replace):replace;replace=str_replace("August","Ağustos",replace)?str_replace("August","Ağustos",replace):replace;replace=str_replace("September","Eylül",replace)?str_replace("September","Eylül",replace):replace;replace=str_replace("October","Ekim",replace)?str_replace("October","Ekim",replace):replace;replace=str_replace("November","Kasım",replace)?str_replace("November","Kasım",replace):replace;replace=str_replace("December","Aralık",replace)?str_replace("December","Aralık",replace):replace;replace=str_replace("reviews","yorumlar",replace)?str_replace("reviews","yorumlar",replace):replace;replace=str_replace("Address","Adres",replace)?str_replace("Address","Adres",replace):replace;replace=str_replace("Website","Web Sitesi",replace)?str_replace("Website","Web Sitesi",replace):replace;replace=str_replace("Phone","Telefon",replace)?str_replace("Phone","Telefon",replace):replace;replace=str_replace("Business Hours","Çalışma Saatleri",replace)?str_replace("Business Hours","Çalışma Saatleri",replace):replace;replace=str_replace("Closed","Kapalı",replace)?str_replace("Closed","Kapalı",replace):replace;replace=str_replace("Coming soon","Yakında",replace)?str_replace("Coming soon","Yakında",replace):replace;replace=str_replace("List","Liste",replace)?str_replace("List","Liste",replace):replace;replace=str_replace("Masonry","Taş işçiliği",replace)?str_replace("Masonry","Taş işçiliği",replace):replace;replace=str_replace("Grid","Izgara",replace)?str_replace("Grid","Izgara",replace):replace;replace=str_replace("Carousel","Karusel",replace)?str_replace("Carousel","Karusel",replace):replace;replace=str_replace("Month","Ay",replace)?str_replace("Month","Ay",replace):replace;replace=str_replace("Export Calendar","Takvimi Dışa Aktar",replace)?str_replace("Export Calendar","Takvimi Dışa Aktar",replace):replace;replace=str_replace("Search here...","Burada ara...",replace)?str_replace("Search here...","Burada ara...",replace):replace;replace=str_replace("second ago","bir saniye önce",replace)?str_replace("second ago","bir saniye önce",replace):replace;replace=str_replace("seconds ago","saniyeler önce",replace)?str_replace("seconds ago","saniyeler önce",replace):replace;replace=str_replace("minute ago","bir dakika önce",replace)?str_replace("minute ago","bir dakika önce",replace):replace;replace=str_replace("minutes ago","dakikalar önce",replace)?str_replace("minutes ago","dakikalar önce",replace):replace;replace=str_replace("hour ago","bir saat önce",replace)?str_replace("hour ago","bir saat önce",replace):replace;replace=str_replace("hours ago","saatler önce",replace)?str_replace("hours ago","saatler önce",replace):replace;replace=str_replace("month ago","bir ay önce",replace)?str_replace("month ago","bir ay önce",replace):replace;replace=str_replace("months ago","aylar önce",replace)?str_replace("months ago","aylar önce",replace):replace;replace=str_replace("day ago","bir gün önce",replace)?str_replace("day ago","bir gün önce",replace):replace;replace=str_replace("days ago","günler önce",replace)?str_replace("days ago","günler önce",replace):replace;replace=str_replace("year ago","bir yıl önce",replace)?str_replace("year ago","bir yıl önce",replace):replace;replace=str_replace("years ago","yıllar önce",replace)?str_replace("years ago","yıllar önce",replace):replace;return replace;}
function getEstonianDayMonth(replace){replace=str_replace("Sunday","Pühapäev",replace)?str_replace("Sunday","Pühapäev",replace):replace;replace=str_replace("SUNDAY","PÜHAPÄEV",replace)?str_replace("SUNDAY","PÜHAPÄEV",replace):replace;replace=str_replace("Monday","Esmaspäev",replace)?str_replace("Monday","Esmaspäev",replace):replace;replace=str_replace("MONDAY","ESMASPÄEV",replace)?str_replace("MONDAY","ESMASPÄEV",replace):replace;replace=str_replace("Tuesday","Teisipäev",replace)?str_replace("Tuesday","Teisipäev",replace):replace;replace=str_replace("TUESDAY","TEISIPÄEV",replace)?str_replace("TUESDAY","TEISIPÄEV",replace):replace;replace=str_replace("Wednesday","Kolmapäev",replace)?str_replace("Wednesday","Kolmapäev",replace):replace;replace=str_replace("WEDNESDAY","KOLMAPÄEV",replace)?str_replace("WEDNESDAY","KOLMAPÄEV",replace):replace;replace=str_replace("Thursday","Neljapäev",replace)?str_replace("Thursday","Neljapäev",replace):replace;replace=str_replace("THURSDAY","NELJAPÄEV",replace)?str_replace("THURSDAY","NELJAPÄEV",replace):replace;replace=str_replace("Friday","Reede",replace)?str_replace("Friday","Reede",replace):replace;replace=str_replace("FRIDAY","REEDE",replace)?str_replace("FRIDAY","REEDE",replace):replace;replace=str_replace("Saturday","Laupäev",replace)?str_replace("Saturday","Laupäev",replace):replace;replace=str_replace("SATURDAY","LAUPÄEV",replace)?str_replace("SATURDAY","LAUPÄEV",replace):replace;replace=str_replace("Closed","Suletud",replace)?str_replace("Closed","Suletud",replace):replace;replace=str_replace("CLOSED","SULETUD",replace)?str_replace("CLOSED","SULETUD",replace):replace;return replace;}
function str_replace(to_replace,replacement,original){var res=original;if(res){res=res.split(to_replace).join(replacement);}
return res;}
function makeFullMonthName(replace){replace=str_replace("Jan ","January ",replace);replace=str_replace("JAN ","January ",replace);replace=str_replace("Feb ","February ",replace);replace=str_replace("FEB ","February ",replace);replace=str_replace("Mar ","March ",replace);replace=str_replace("MAR ","March ",replace);replace=str_replace("Apr ","April ",replace);replace=str_replace("APR ","April ",replace);replace=str_replace("May ","May ",replace);replace=str_replace("MAY ","May ",replace);replace=str_replace("Jun ","June ",replace);replace=str_replace("JUN ","June ",replace);replace=str_replace("Jul ","July ",replace);replace=str_replace("JUL ","July ",replace);replace=str_replace("Aug ","August ",replace);replace=str_replace("AUG ","August ",replace);replace=str_replace("Sep ","September ",replace);replace=str_replace("SEP ","September ",replace);replace=str_replace("Oct ","October ",replace);replace=str_replace("OCT ","October ",replace);replace=str_replace("Nov ","November ",replace);replace=str_replace("NOV ","November ",replace);replace=str_replace("Dec ","December ",replace);replace=str_replace("DEC ","December ",replace);return replace;}
function languageCode(translation){var locale="";if(translation=="Spanish"){locale="es";}
if(translation=="Croatian"){locale="hr";}
if(translation=="Norwegian"){locale="no";}
if(translation=="Swedish"){locale="sv";}
if(translation=="Filipino"){locale="";}
if(translation=="French"){locale="fr";}
if(translation=="German"){locale="";}
if(translation=="Polish"){locale="";}
if(translation=="Russian"){locale="ru";}
if(translation=="Faroese"){locale="fo";}
if(translation=="Portuguese"){locale="pt";}
if(translation=="Danish"){locale="da";}
if(translation=="Dutch"){locale="nl";}
if(translation=="Hungarian"){locale="hu";}
if(translation=="German"){locale="de";}
if(translation=="Italian"){locale="it";}
return locale;}function loadGoogleFont(font_family){var web_safe_fonts=["Inherit","Impact, Charcoal, sans-serif","'Palatino Linotype', 'Book Antiqua', Palatino, serif","Century Gothic, sans-serif","'Lucida Sans Unicode', 'Lucida Grande', sans-serif","Verdana, Geneva, sans-serif","Copperplate, 'Copperplate Gothic Light', fantasy","'Courier New', Courier, monospace","Georgia, Serif"];if(!web_safe_fonts.includes(font_family)){try{loadCssFile("https://fonts.googleapis.com/css?family="+font_family);}catch(error){}}}
function readableNumber(number){number=parseInt(number);number=number?number.toLocaleString("en-US"):0;return number;}
function addDescriptiveTagAttributes(_sk,add_to_img=true){_sk.find('a').each(function(i,v){var title=jQuery(v).text();if(!jQuery(v).attr('title')){jQuery(v).attr('title',title);}});if(add_to_img){_sk.find('img').each(function(i,v){var src=jQuery(v).attr('src');jQuery(v).attr('alt','Post image');});}}
function getClientId(){var _gaCookie=document.cookie.match(/(^|[;,]\s?)_ga=([^;,]*)/);if(_gaCookie)return _gaCookie[2].match(/\d+\.\d+$/)[0];}
function getSkEmbedId(sk_class){var embed_id=sk_class.attr('embed-id');if(embed_id==undefined){embed_id=sk_class.attr('data-embed-id');}
return embed_id;}
function getSkSetting(sk_class,key){return sk_class.find("div."+key).text();}
function setCookieSameSite(){document.cookie="AC-C=ac-c;expires=Fri, 31 Dec 2025 23:59:59 GMT;path=/;HttpOnly;SameSite=Lax";}
function getIEVersion(){var sAgent=window.navigator.userAgent;var Idx=sAgent.indexOf("MSIE");if(Idx>0)
return parseInt(sAgent.substring(Idx+5,sAgent.indexOf(".",Idx)));else if(!!navigator.userAgent.match(/Trident\/7\./))
return 11;else
return 0;}
function isSafariBrowser(){var ua=navigator.userAgent.toLowerCase();if(ua.indexOf('safari')!=-1){if(ua.indexOf('chrome')>-1){return 0;}else{return 1;}}}
if(getIEVersion()>0||isSafariBrowser()>0){loadIEScript('https://cdn.jsdelivr.net/bluebird/3.5.0/bluebird.min.js');loadIEScript('https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.3/fetch.js');}
function loadIEScript(url){var scriptTag=document.createElement('script');scriptTag.setAttribute("type","text/javascript");scriptTag.setAttribute("src",url);(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(scriptTag);}
function kFormatter(num){return Math.abs(num)>999?Math.sign(num)*((Math.abs(num)/1000).toFixed(1))+'k':Math.sign(num)*Math.abs(num)}
function sk_increaseView(user_info){try{if(user_info&&user_info.status&&(user_info.status==1||user_info.status==6||user_info.status==7||user_info.status==13)){jQuery.getJSON('https://api.ipify.org?format=json',function(data){var update_views_url="https://views.accentapi.com/add_view.php?user_id="+user_info.id+"&url="+document.URL+"&ip_address="+data.ip+"&embed_id="+user_info.embed_id;if(app_url.includes("local")&&sk_app_url){update_views_url="https://localtesting.com/accentapiviews/add_view.php?user_id="+user_info.id+"&url="+document.URL+"&ip_address="+data.ip+"&embed_id="+user_info.embed_id;}
jQuery.ajax(update_views_url);});}}
catch(err){console.log("Error retrieving ip address.");}}
function isTooDarkColor(hexcolor){var r=parseInt(hexcolor.substr(1,2),16);var g=parseInt(hexcolor.substr(3,2),16);var b=parseInt(hexcolor.substr(4,2),16);if(hexcolor.indexOf('rgb')!=-1){let rgbstr=hexcolor;let v=getRGB(rgbstr);r=v[0];g=v[1];b=v[2];}
b=isNaN(b)?0:b;var yiq=((r*299)+(g*587)+(b*114))/1000;if(yiq<60){}
else{}
return yiq<60?true:false;}
function linkify(html){var temp_text=html.split("https://www.").join("https://");temp_text=temp_text.split("www.").join("https://www.");var exp=/((href|src)=["']|)(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;return temp_text.replace(exp,function(){return arguments[1]?arguments[0]:"<a href=\""+arguments[3]+"\">"+arguments[3]+"</a>"});}
function skGetEnvironmentUrls(folder_name){var scripts=document.getElementsByTagName("script");var scripts_length=scripts.length;var search_result=-1;var other_result=-1;var app_url="https://widgets.sociablekit.com/";var app_backend_url="https://api.accentapi.com/v1/";var app_file_server_url="https://data.accentapi.com/feed/";var sk_app_url="https://sociablekit.com/app/";var sk_api_url="https://api.sociablekit.com/";var sk_img_url="https://images.sociablekit.com/";var sk_fb_sync_url="https://facebook-sync.sociablekit.com/";for(var i=0;i<scripts_length;i++){var src_str=scripts[i].getAttribute('src');if(src_str!=null){var other_folder="";if(folder_name=='facebook-page-playlists'){other_folder='facebook-page-playlist';}
else if(folder_name=='linkedin-page-posts'){other_folder='linkedin-page-post';}
else if(folder_name=='linkedin-profile-posts'){other_folder='linkedin-profile-post';}
else if(folder_name=='facebook-hashtag-posts'){other_folder='facebook-hashtag-feed';}
else if(folder_name=='facebook-page-events'){other_folder='facebook-events';}
else if(folder_name=='facebook-page-posts'){other_folder='facebook-feed';if(document.querySelector(".sk-ww-facebook-feed")){var element=document.getElementsByClassName("sk-ww-facebook-feed")[0];element.classList.add("sk-ww-facebook-page-posts");}}
other_result=src_str.search(other_folder);search_result=src_str.search(folder_name);if(search_result>=1||other_result>=1){var src_arr=src_str.split(folder_name);app_url=src_arr[0];app_url=app_url.replace("displaysocialmedia.com","sociablekit.com");if(app_url.search("local")>=1){app_backend_url="http://localhost:3000/v1/";app_url="https://localtesting.com/SociableKIT_Widgets/";app_file_server_url="https://localtesting.com/SociableKIT_FileServer/feed/";sk_app_url="https://localtesting.com/SociableKIT/";sk_api_url="http://127.0.0.1:8000/";sk_img_url="https://localtesting.com/SociableKIT_Images/";sk_fb_sync_url="https://localtesting.com/SociableKIT_Facebook_Sync/";}
else{app_url="https://widgets.sociablekit.com/";}}}}
return{"app_url":app_url,"app_backend_url":app_backend_url,"app_file_server_url":app_file_server_url,"sk_api_url":sk_api_url,"sk_app_url":sk_app_url,"sk_img_url":sk_img_url,"sk_fb_sync_url":sk_fb_sync_url};}
function changeBackSlashToBR(text){if(text){for(var i=1;i<=10;i++){text=text.replace('\n','</br>');}}
return text;}
function sKGetScrollbarWidth(){var outer=document.createElement('div');outer.style.visibility='hidden';outer.style.overflow='scroll';outer.style.msOverflowStyle='scrollbar';document.body.appendChild(outer);var inner=document.createElement('div');outer.appendChild(inner);var scrollbarWidth=(outer.offsetWidth-inner.offsetWidth);outer.parentNode.removeChild(outer);return scrollbarWidth;}
function isValidURL(url){const urlPattern=/^(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;return urlPattern.test(url);}
async function showUrlData(element,url,post_id,type="",show_thumbnail=1){element.hide();var check_url=url&&url.includes('&')?encodeURIComponent(url):url;var free_data_url=app_file_server_url.replace("feed/","get_fresh_url_tags.php")+'?post_id='+post_id+'&url='+check_url;var read_one_url=app_file_server_url.replace("feed","url-tags")+post_id+".json";if(jQuery('.sk_version').text()){read_one_url+="?v="+jQuery('.sk_version').text();}
fetch(read_one_url,{method:'get',cache:'no-cache'}).then(async response=>{if(response.ok){let data=await response.json();if(data&&data.status&&data.status==418){displayUrlData(data,element,type,show_thumbnail,post_id);data=await jQuery.ajax(free_data_url);}
return data;}
else{response=await jQuery.ajax(free_data_url);displayUrlData(response,element,type,show_thumbnail,post_id);return response;}}).then(async response=>{if(response!=undefined){displayUrlData(response,element,type,show_thumbnail,post_id);}else{response=await jQuery.ajax(free_data_url);displayUrlData(response,element,type,show_thumbnail,post_id);}}).catch(async error=>{var data=await jQuery.ajax(free_data_url);displayUrlData(data,element,type,show_thumbnail,post_id);});}
async function displayUrlData(response,element,type,show_thumbnail=1,post_id){var meta_holder=jQuery(element);var html="";if(!response||response.error){if(meta_holder.html()){meta_holder.show();}
return;}
if(response.message&&response.message=="Data not available. Please try again."){return;}
if(response.messages&&response.messages.length>0&&response.messages[0]=="PDF files that are over 10Mb are not supported by Google Docs Viewer"){var data=response.url;if(response.url){data=response.url.replace("https://","").split("/");}
if(data.length>0){if(data.length>1){response.title=data[data.length-1];}
response.description=data[0].replace("www.","");}}
if(post_id=="7059257055500492800"){response.url+="?id=122630";}
if(response.html&&meta_holder.closest('.sk-ww-twitter-feed').length>0){html+=response.html;}else if(response.title&&response.title.includes("NCBI - WWW Error Blocked Diagnostic")){console.log(meta_holder);html+="<a href='"+meta_holder.data('link')+"' link-only target='_blank'>";html+="<div class='sk-link-article-container' style='background: #eeeeee;color: black !important; font-weight: bold !important; border-radius: 2px; border: 1px solid #c3c3c3; box-sizing: border-box; word-wrap: break-word;'>";if(show_thumbnail==1){html+="<image alt='No alternative text description for this image' class='sk-link-article-image sk_post_img_link' onerror='this.style.display=\"none\"' src='"+meta_holder.data('image')+"'/>";}
if(response.title){html+="<div class='sk-link-article-title' style='padding: 8px;'>"+meta_holder.data('title')+"</div>";}
html+="</div>";html+="</a>";}
else{html+="<a href='"+response.url+"' link-only target='_blank'>";html+="<div class='sk-link-article-container' style='background: #eeeeee;color: black !important; font-weight: bold !important; border-radius: 2px; border: 1px solid #c3c3c3; box-sizing: border-box; word-wrap: break-word;'>";if(show_thumbnail==1){html+="<image alt='No alternative text description for this image' class='sk-link-article-image sk_post_img_link' onerror='this.style.display=\"none\"' src='"+response.thumbnail_url+"'/>";}
if(response.title){html+="<div class='sk-link-article-title' style='padding: 8px;'>"+response.title+"</div>";}
else if(response.url&&response.url.indexOf(".pdf")!=-1){html+=response.html;}
if(type&&type==6){if(response.description&&response.description.length>0){response.description=response.description.length>140?response.description.substring(0,140)+' ...':response.description;}}
if(response.description&&response.description.indexOf("[vc_row]")!==-1&&response.url){var pathArray=response.url.split('/');var protocol=pathArray[0];if(pathArray.length>2){var host=pathArray[2];var url=protocol+'//'+host;html+="<div class='sk-link-article-description' style='padding: 8px;color: grey;font-weight: 100;font-size: 14px;'>"+url+"</div>";}}
else if(response.description&&response.description.indexOf("fb_built")==-1&&response.description!="null"){if(response.url){var domain=new URL(response.url).hostname;response.description=domain;}
html+="<div class='sk-link-article-description' style='padding: 8px;color: #000000;font-weight: 100;font-size: 14px;'>"+response.description+"</div>";}
else if(response.url&&response.url.includes('instagram.com/p/')){html+="<image style='padding: 8px;' alt='No alternative text description for this image' class='sk-ig-default' onerror='this.style.display=\"none\"' src='https://i1.wp.com/sociablekit.com/wp-content/uploads/2019/01/instagram.png'/>";html+="<div class='sk-link-article-description' style='padding: 8px;margin-left:15%;color: #000000;font-weight: 600;font-size: 14px;'>View this post in instagram</div>";html+="<div class='sk-link-article-description' style='padding: 0px 8px ;margin-left:15%;margin-bottom:10px;color: #000000;font-weight: 100;font-size: 10px;'>"+response.url+"</div>";}
html+="</div>";html+="</a>";}
meta_holder.html(html);meta_holder.css('display','block');meta_holder.css('margin-bottom','15px');meta_holder.find('.sk-ig-default').closest('.sk-link-article-container').css('display','inline-block');meta_holder.find('.sk-ig-default').closest('.sk-link-article-container').css('width','100%');meta_holder.find('.sk-ig-default').css('width','20%');meta_holder.find('.sk-ig-default').css('float','left');applyMasonry();}
function slugifyString(str){str=str.replace(/^\s+|\s+$/g,'');str=str.toLowerCase();var from="ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";var to="AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";for(var i=0,l=from.length;i<l;i++){str=str.replace(new RegExp(from.charAt(i),'g'),to.charAt(i));}
str=str.replace(/[^a-z0-9 -]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');return str;}
function skGetBranding(sk_,user_info){sk_.find('.sk_branding').remove();sk_.find('div.user_email').remove();var html="";if(!user_info)
return;var slugify_string="";if(user_info.solution_name){slugify_string=slugifyString(user_info.solution_name);user_info.tutorial_link="https://www.sociablekit.com/tutorials/embed-"+slugify_string+"-website/";if(user_info.website_builder){user_info.tutorial_link="https://www.sociablekit.com/tutorials/embed-"+slugify_string;slugify_string=slugifyString(user_info.website_builder);user_info.tutorial_link=user_info.tutorial_link+"-"+slugify_string;}}
if(user_info.type==9){user_info.tutorial_link="https://www.sociablekit.com/sync-facebook-page-events-to-google-calendar/";}
else if(user_info.type==26){user_info.tutorial_link="https://www.sociablekit.com/how-to-sync-facebook-group-events-to-google-calendar-on-website/";}
if(user_info.show_branding&&(user_info.show_branding==1||user_info.show_branding=="true")||user_info.show_branding==true){var fontFamily=getSkSetting(sk_,"font_family");var link_color=getSkSetting(sk_,"details_link_color");var details_bg_color=getSkSetting(sk_,"details_bg_color");if(link_color==""){link_color="rgb(52, 128, 220)";}
if(details_bg_color&&isTooDarkColor(link_color)==false&&isTooDarkColor(details_bg_color)==false){link_color='#3480dc';}
var temporary_tutorial_link=user_info.tutorial_link;if(temporary_tutorial_link.endsWith("/")==false){temporary_tutorial_link=temporary_tutorial_link+"/";}
var linkedin_widgets=[33,34,44,58,75,99,100,103];if(linkedin_widgets.includes(user_info.type)&&user_info.embed_id%2==1){var website_builder="website";if(user_info.website_builder){website_builder=slugifyString(user_info.website_builder);}
temporary_tutorial_link="https://www.sociablekit.com/tutorials/embed-linkedin-feed-"+website_builder+"/";}
if(user_info.type==5&&user_info.embed_id%2==1){temporary_tutorial_link=temporary_tutorial_link.replace("profile","feed")}
var facebook_feed=[1,4,9,10,11,36,38,43,12,24,26,49,2,8,3,18,19,28,30,61];if(facebook_feed.includes(user_info.type)&&user_info.embed_id%2==1){var website_builder="website";if(user_info.website_builder){website_builder=slugifyString(user_info.website_builder);}
temporary_tutorial_link="https://www.sociablekit.com/tutorials/embed-facebook-feed-"+website_builder+"/";}
var threads_feed=[110];if(threads_feed.includes(user_info.type)&&user_info.embed_id%2==0){var website_builder="website";if(user_info.website_builder){website_builder=slugifyString(user_info.website_builder);}
temporary_tutorial_link="https://www.sociablekit.com/tutorials/embed-threads-"+website_builder+"/";}
var nofollow_attribute="";if(window.location.href.includes("clean-concept-plus")){nofollow_attribute="rel='nofollow'";}
html+="<div class='sk_branding' style='padding:10px; display:block !important; text-align:center; text-decoration: none !important; color:#555; font-family:"+fontFamily+"; font-size:15px;'>";html+="<a "+nofollow_attribute+" class='tutorial_link' href='"+temporary_tutorial_link+"' target='_blank' style='text-underline-position:under; color:"+link_color+";font-size:15px;'>";if(linkedin_widgets.includes(user_info.type)&&user_info.embed_id%2==1){html+="Embed LinkedIn Feed on your ";if(user_info.website_builder&&user_info.website_builder!="Website"){html+=user_info.website_builder;}}else if(facebook_feed.includes(user_info.type)&&user_info.embed_id%2==1){html+="Embed Facebook Feed on your ";if(user_info.website_builder&&user_info.website_builder!="Website"){html+=user_info.website_builder;}}else{html+="Embed "+user_info.solution_name+" on your ";if(user_info.website_builder&&user_info.website_builder!="Website"){html+=user_info.website_builder;}}
html+=" website";html+="</a>";html+="</div>";}
return html;}
function getRGB(rgbstr){return rgbstr.substring(4,rgbstr.length-1).replace(/ /g,'').replace('(','').split(',');}
function freeTrialEndedMessage(solution_info){var sk_error_message="<div class='sk_trial_ended_message'>";sk_error_message+="Customized feed is powered by <strong><a href='https://www.sociablekit.com/' target='_blank'>SociableKIT</a></strong>.<br>";sk_error_message+="If you're the owner of this website, your 7-day Free Trial has ended.<br>";sk_error_message+="If you want to continue using our services, please <strong><a target='_blank' href='https://www.sociablekit.com/app/users/subscription/subscription'>subscribe now</a></strong>.";sk_error_message+="</div>";return sk_error_message;}
function privateFBGroupMessage(){var sk_error_message="<div class='sk_trial_ended_message'>";sk_error_message+="<h2>The Facebook group is private, it must be <a target='_blank' href='https://www.facebook.com/community/using-key-groups-tools/understanding-your-privacy-settings/'>public</a>.</h2>";sk_error_message+="</div>";return sk_error_message;}
function isFreeTrialEnded(start_date){var start_date=new Date(start_date);var current_date=new Date();var difference=current_date.getTime()-start_date.getTime();difference=parseInt(difference/(1000*60*60*24));return difference>7?true:false;}
function unableToLoadSKErrorMessage(solution_info,additional_error_messages){var sk_error_message="<ul class='sk_error_message'>";sk_error_message+="<li><a href='"+solution_info.embed_id+"' target='_blank'>Customized "+solution_info.solution_name+" feed by SociableKIT</a></li>";console.log(solution_info);sk_error_message+="<li>Unable to load "+solution_info.solution_name+".</li>";for(var i=0;i<additional_error_messages.length;i++){sk_error_message+=additional_error_messages[i];}
sk_error_message+="<li>If you think there is a problem, <a target='_blank' href='https://go.crisp.chat/chat/embed/?website_id=2e3a484e-b418-4643-8dd2-2355d8eddc6b'>chat with support here</a>. We will solve it for you.</li>";sk_error_message+="</ul>";return sk_error_message;}
function widgetValidation(_sk,data){if(data.user_info){var user_info=data.user_info;user_info.trial_ended=false;user_info.show_feed=user_info.show_feed==="false"?false:true;if(user_info.status==7&&user_info.cancellation_date){var cancellation_date=new Date(user_info.cancellation_date).setHours(0,0,0,0);var current_date=new Date().setHours(0,0,0,0);user_info.show_feed=current_date>cancellation_date?false:true;var activation_date=new Date(user_info.activation_date).setHours(0,0,0,0);if(activation_date>cancellation_date){user_info.show_feed=true;}
if(!user_info.show_feed){var sk_error_message=generateBlueMessage(_sk,user_info);_sk.find(".first_loading_animation").hide();_sk.html(sk_error_message);return;}}
else if(user_info.status==0||user_info.status==2||user_info.status==10){user_info.show_feed=false;}
if(user_info.type==43||user_info.type==38||user_info.type==50){var sk_error_message="<div class='sk_error_message'>";sk_error_message+="<p style='text-align: center !important; margin: 1rem'>"+user_info.solution_name+" are currently unavailable, please choose another <a href='https://www.sociablekit.com/demos/' target='_blank'>widget here</a></p>";sk_error_message+="</div>";_sk.find(".first_loading_animation").hide();_sk.html(sk_error_message);return;}
else if(!user_info.show_feed){var sk_error_message=generateBlueMessage(_sk,user_info);_sk.find(".first_loading_animation").hide();_sk.html(sk_error_message);return;}
else if(user_info.widget_status==1){var sk_error_message=generateBlueMessage(_sk,user_info);_sk.find(".first_loading_animation").hide();_sk.html(sk_error_message);return;}
return user_info.show_feed;}}
function generateBlueMessage(_sk,user_info){var tutorial_link="";var sk_error_message="";if(user_info.solution_name){var slugify_string=slugifyString(user_info.solution_name);tutorial_link="https://www.sociablekit.com/tutorials/embed-"+slugify_string+"-website/";}
if(user_info.type==9){tutorial_link="https://www.sociablekit.com/sync-facebook-page-events-to-google-calendar/";}
else if(user_info.type==26){tutorial_link="https://www.sociablekit.com/how-to-sync-facebook-group-events-to-google-calendar-on-website/";}
if(user_info.widget_status==1){var sk_error_message="<div class='sk_error_message'>";sk_error_message+="<p style='text-align: center !important; margin: 1rem'> The widget does not exist. If you think this is a mistake, please contact support</a></p>";sk_error_message+="</div>";return sk_error_message;}
if(user_info.show_feed==false){if(!user_info.message||user_info.message==""){var sk_error_message="<ul class='sk_error_message'>";sk_error_message+="<li><a href='"+tutorial_link+"' target='_blank'>"+user_info.solution_name+" powered by SociableKIT</a></li>";sk_error_message+="<li>If you’re the owner of this website or SociableKIT account used, we found some errors with your account.</li>";sk_error_message+="<li>Please login your SociableKIT account to fix it.</li>";sk_error_message+="</ul>";user_info.message=sk_error_message;}
sk_error_message=user_info.message;}
else if(user_info.solution_name==null&&user_info.type==null&&user_info.start_date==null){sk_error_message="<p class='sk_error_message'>";sk_error_message+="The SociableKIT solution does not exist. If you think this is a mistake, please contact support.";sk_error_message+="</p>";}
else{sk_error_message="<div class='sk_error_message'>";sk_error_message+="<div style='display: inline-flex;width:100%;'>";sk_error_message+="<div>";sk_error_message+="<h4>SociableKIT is currently syncing your <a href='"+tutorial_link+"' target='_blank'>"+user_info.solution_name+" widget.</a></h4>";sk_error_message+=`<svg width="480"height="20"><rect x="0"y="0"width="480"height="20"fill="#f0f0f0"rx="10"ry="10"/><pattern id="stripes"x="0"y="0"width="20"height="20"patternUnits="userSpaceOnUse"patternTransform="rotate(45)"><rect x="0"y="0"width="10"height="20"fill="#007bff"/></pattern><rect id="progressBar"x="0"y="0"width="0"height="20"fill="url(#stripes)"rx="10"ry="10"><animate attributeName="width"attributeType="XML"from="0"to="480"dur="2s"repeatCount="indefinite"/></rect></svg>`;sk_error_message+="<p>While waiting there are a few things you need to know:</p>";sk_error_message+="<ul>";sk_error_message+="<li>It usually takes only a few minutes. We appreciate your patience.</li>";sk_error_message+="<li>We will notify you via email once your "+user_info.solution_name+" feed is ready.</li>";if(user_info.type==5){sk_error_message+="<li>Make sure your instagram account <a target='_blank' href='https://www.instagram.com/"+getDsmSetting(_sk,'username')+"' target='_blank'><b>@"+getDsmSetting(_sk,'username')+"</b></a> is connected.</li>";}
else if(user_info.type==22||user_info.type==39){sk_error_message+="<li>Please make sure that you selected the correct Google Place or that the <a href='https://www.sociablekit.com/how-to-identify-google-place-id/' target='blank'><b> Google Place ID </b></a> you entered is correct.</li>";}
else{sk_error_message+="<li>Please make sure that the <b> Source ID/Username </b> you enter is correct.</li>";}
sk_error_message+="<li>If you think there is a problem, <a target='_blank' href='https://go.crisp.chat/chat/embed/?website_id=2e3a484e-b418-4643-8dd2-2355d8eddc6b'>chat with support here</a>. We will solve it for you.</li>";sk_error_message+="</ul>";sk_error_message+="</div>";sk_error_message+="</div>";sk_error_message+="</div>";}
return sk_error_message;}
function generateSolutionMessage(_sk,embed_id){var json_url=sk_api_url+"api/user_embed/info/"+embed_id;var sk_error_message="";jQuery.getJSON(json_url,function(data){if(data.type==1&&data.encoded==true){loadEvents(_sk);}
else if(data.type==44&&data.encoded==true){loadFeed(_sk);}
else if(data.type==58&&data.encoded==true){var no_data_text=_sk.find('.no_data_text').text();_sk.html("<div style='padding: 20px;text-align: center;'>"+no_data_text+"</div>");}
else if(data.type==67&&data.encoded==true){loadEvents(_sk);}
else if(data.type==74&&data.encoded==true){_sk.html("<div>No jobs yet, please try again later.</div>");}
else if((data.type==12||data.type==26||data.type==24||data.type==49)&&data.encoded==true){_sk.html(privateFBGroupMessage());}
else{var sk_error_message=generateBlueMessage(_sk,data);_sk.find(".first_loading_animation").hide();_sk.html(sk_error_message);}}).fail(function(e){console.log(e);});}
function copyInput(copy_button,copy_input){var copy_button_orig_html=copy_button.html();copy_input.select();try{var successful=document.execCommand('copy');var msg=successful?'successful':'unsuccessful';if(msg=='successful'){copy_button.html("<i class='fa fa-clipboard'></i> Copied!");setTimeout(function(){copy_button.html(copy_button_orig_html);},3000);}
else{alert('Copying text command was '+msg+'.');}}
catch(err){alert('Oops, unable to copy.');}}
function getDefaultLinkedInPageProfilePicture(profile_picture){if(profile_picture&&profile_picture.indexOf("data:image/gif")!=-1){profile_picture="https://gmalcilk.sirv.com/iamge.JPG";}
return profile_picture;}
function detectedSKDashboard(){let parent_url=(window.location!=window.parent.location)?document.referrer:document.location.href;if(parent_url&&(parent_url.indexOf("sociablekit.com")!=-1||parent_url.indexOf("local")!=-1)){return true;}
return false;}
function getSKDashboardPremiumTrialMessage(){var sk_error_message="";sk_error_message+="<ul class='sk_error_message'>";sk_error_message+="<li>Your 7-days premium trial has ended.</li>";sk_error_message+="<li>Please purchase a <a href='https://www.sociablekit.com/app/users/subscription/subscription?action=subscribe_now'>SociableKIT subscription plan</a> ";sk_error_message+="to save your widget customizations, save time with automatic sync, enjoy priority support, and get a 50% discount on any annual plans. Don’t miss out!</li>";sk_error_message+="<li>You may also choose to <a href='https://help.sociablekit.com/en-us/article/how-to-activate-the-free-plan-1l3o0nt/'>activate the free plan</a> if you don't need our premium features.</li>";sk_error_message+="</ul>";return sk_error_message;}
function getSocialIcon(category)
{var post_items='';if(category.indexOf("Facebook")!=-1){post_items+="<i class='fab fa-facebook' aria-hidden='true'></i>";}
else if(category.indexOf("Instagram")!=-1){post_items+="<i class='fab fa-instagram' aria-hidden='true'></i>";}
else if(category.indexOf("Linkedin")!=-1){post_items+="<i class='fab fa-linkedin' aria-hidden='true'></i>";}
else if(category.indexOf("Youtube")!=-1){post_items+="<i class='fab fa-youtube' aria-hidden='true'></i>";}
else if(category.indexOf("Google")!=-1){post_items+="<i class='fab fa-google' aria-hidden='true'></i>";}
else if(category.indexOf("Twitter")!=-1){post_items+='<i class="fa-brands fa-x-twitter"></i>';}
else if(category.indexOf("Twitch")!=-1){post_items+="<i class='fab fa-twitch' aria-hidden='true'></i>";}
else if(category.indexOf("Yelp")!=-1){post_items+="<i class='fab fa-yelp' aria-hidden='true'></i>";}
else if(category.indexOf("Vimeo")!=-1){post_items+="<i class='fab fa-vimeo' aria-hidden='true'></i>";}
else if(category.indexOf("Twitch")!=-1){post_items+="<i class='fab fa-twitch' aria-hidden='true'></i>";}
else if(category.indexOf("Trust")!=-1){post_items+="<i class='fab fa-trustpilot' aria-hidden='true'></i>";}
else if(category.indexOf("Spot")!=-1){post_items+="<i class='fab fa-spotify' aria-hidden='true'></i>";}
return post_items;}
function isFontAwesomeLoaded(){var span=document.createElement('span');span.className='fa';span.style.display='none';document.body.insertBefore(span,document.body.firstChild);var font=css(span,'font-family');if(font.indexOf("fontawesome")==-1){return false;}
document.body.removeChild(span);return true;}
function css(element,property){let font=window.getComputedStyle(element,null).getPropertyValue(property);if(font){font=font.toLowerCase();return font.replace(/' '/g,"");}
return'na';}}(window,document));
// ========== start flatpickr
/* flatpickr v4.5.2, @license MIT */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.flatpickr = factory());
}(this, (function () { 'use strict';

    var pad = function pad(number) {
      return ("0" + number).slice(-2);
    };
    var int = function int(bool) {
      return bool === true ? 1 : 0;
    };
    function debounce(func, wait, immediate) {
      if (immediate === void 0) {
        immediate = false;
      }

      var timeout;
      return function () {
        var context = this,
            args = arguments;
        timeout !== null && clearTimeout(timeout);
        timeout = window.setTimeout(function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
      };
    }
    var arrayify = function arrayify(obj) {
      return obj instanceof Array ? obj : [obj];
    };

    var do_nothing = function do_nothing() {
      return undefined;
    };

    var monthToStr = function monthToStr(monthNumber, shorthand, locale) {
      return locale.months[shorthand ? "shorthand" : "longhand"][monthNumber];
    };
    var revFormat = {
      D: do_nothing,
      F: function F(dateObj, monthName, locale) {
        dateObj.setMonth(locale.months.longhand.indexOf(monthName));
      },
      G: function G(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      H: function H(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      J: function J(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      K: function K(dateObj, amPM, locale) {
        dateObj.setHours(dateObj.getHours() % 12 + 12 * int(new RegExp(locale.amPM[1], "i").test(amPM)));
      },
      M: function M(dateObj, shortMonth, locale) {
        dateObj.setMonth(locale.months.shorthand.indexOf(shortMonth));
      },
      S: function S(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      U: function U(_, unixSeconds) {
        return new Date(parseFloat(unixSeconds) * 1000);
      },
      W: function W(dateObj, weekNum) {
        var weekNumber = parseInt(weekNum);
        return new Date(dateObj.getFullYear(), 0, 2 + (weekNumber - 1) * 7, 0, 0, 0, 0);
      },
      Y: function Y(dateObj, year) {
        dateObj.setFullYear(parseFloat(year));
      },
      Z: function Z(_, ISODate) {
        return new Date(ISODate);
      },
      d: function d(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      h: function h(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      i: function i(dateObj, minutes) {
        dateObj.setMinutes(parseFloat(minutes));
      },
      j: function j(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      l: do_nothing,
      m: function m(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      n: function n(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      s: function s(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      w: do_nothing,
      y: function y(dateObj, year) {
        dateObj.setFullYear(2000 + parseFloat(year));
      }
    };
    var tokenRegex = {
      D: "(\\w+)",
      F: "(\\w+)",
      G: "(\\d\\d|\\d)",
      H: "(\\d\\d|\\d)",
      J: "(\\d\\d|\\d)\\w+",
      K: "",
      M: "(\\w+)",
      S: "(\\d\\d|\\d)",
      U: "(.+)",
      W: "(\\d\\d|\\d)",
      Y: "(\\d{4})",
      Z: "(.+)",
      d: "(\\d\\d|\\d)",
      h: "(\\d\\d|\\d)",
      i: "(\\d\\d|\\d)",
      j: "(\\d\\d|\\d)",
      l: "(\\w+)",
      m: "(\\d\\d|\\d)",
      n: "(\\d\\d|\\d)",
      s: "(\\d\\d|\\d)",
      w: "(\\d\\d|\\d)",
      y: "(\\d{2})"
    };
    var formats = {
      Z: function Z(date) {
        return date.toISOString();
      },
      D: function D(date, locale, options) {
        return locale.weekdays.shorthand[formats.w(date, locale, options)];
      },
      F: function F(date, locale, options) {
        return monthToStr(formats.n(date, locale, options) - 1, false, locale);
      },
      G: function G(date, locale, options) {
        return pad(formats.h(date, locale, options));
      },
      H: function H(date) {
        return pad(date.getHours());
      },
      J: function J(date, locale) {
        return locale.ordinal !== undefined ? date.getDate() + locale.ordinal(date.getDate()) : date.getDate();
      },
      K: function K(date, locale) {
        return locale.amPM[int(date.getHours() > 11)];
      },
      M: function M(date, locale) {
        return monthToStr(date.getMonth(), true, locale);
      },
      S: function S(date) {
        return pad(date.getSeconds());
      },
      U: function U(date) {
        return date.getTime() / 1000;
      },
      W: function W(date, _, options) {
        return options.getWeek(date);
      },
      Y: function Y(date) {
        return date.getFullYear();
      },
      d: function d(date) {
        return pad(date.getDate());
      },
      h: function h(date) {
        return date.getHours() % 12 ? date.getHours() % 12 : 12;
      },
      i: function i(date) {
        return pad(date.getMinutes());
      },
      j: function j(date) {
        return date.getDate();
      },
      l: function l(date, locale) {
        return locale.weekdays.longhand[date.getDay()];
      },
      m: function m(date) {
        return pad(date.getMonth() + 1);
      },
      n: function n(date) {
        return date.getMonth() + 1;
      },
      s: function s(date) {
        return date.getSeconds();
      },
      w: function w(date) {
        return date.getDay();
      },
      y: function y(date) {
        return String(date.getFullYear()).substring(2);
      }
    };

    var english = {
      weekdays: {
        shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        longhand: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
      },
      months: {
        shorthand: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        longhand: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
      },
      daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      firstDayOfWeek: 0,
      ordinal: function ordinal(nth) {
        var s = nth % 100;
        if (s > 3 && s < 21) return "th";

        switch (s % 10) {
          case 1:
            return "st";

          case 2:
            return "nd";

          case 3:
            return "rd";

          default:
            return "th";
        }
      },
      rangeSeparator: " to ",
      weekAbbreviation: "Wk",
      scrollTitle: "Scroll to increment",
      toggleTitle: "Click to toggle",
      amPM: ["AM", "PM"],
      yearAriaLabel: "Year"
    };

    var createDateFormatter = function createDateFormatter(_ref) {
      var _ref$config = _ref.config,
          config = _ref$config === void 0 ? defaults : _ref$config,
          _ref$l10n = _ref.l10n,
          l10n = _ref$l10n === void 0 ? english : _ref$l10n;
      return function (dateObj, frmt, overrideLocale) {
        var locale = overrideLocale || l10n;

        if (config.formatDate !== undefined) {
          return config.formatDate(dateObj, frmt, locale);
        }

        return frmt.split("").map(function (c, i, arr) {
          return formats[c] && arr[i - 1] !== "\\" ? formats[c](dateObj, locale, config) : c !== "\\" ? c : "";
        }).join("");
      };
    };
    var createDateParser = function createDateParser(_ref2) {
      var _ref2$config = _ref2.config,
          config = _ref2$config === void 0 ? defaults : _ref2$config,
          _ref2$l10n = _ref2.l10n,
          l10n = _ref2$l10n === void 0 ? english : _ref2$l10n;
      return function (date, givenFormat, timeless, customLocale) {
        if (date !== 0 && !date) return undefined;
        var locale = customLocale || l10n;
        var parsedDate;
        var date_orig = date;
        if (date instanceof Date) parsedDate = new Date(date.getTime());else if (typeof date !== "string" && date.toFixed !== undefined) parsedDate = new Date(date);else if (typeof date === "string") {
          var format = givenFormat || (config || defaults).dateFormat;
          var datestr = String(date).trim();

          if (datestr === "today") {
            parsedDate = new Date();
            timeless = true;
          } else if (/Z$/.test(datestr) || /GMT$/.test(datestr)) parsedDate = new Date(date);else if (config && config.parseDate) parsedDate = config.parseDate(date, format);else {
            parsedDate = !config || !config.noCalendar ? new Date(new Date().getFullYear(), 0, 1, 0, 0, 0, 0) : new Date(new Date().setHours(0, 0, 0, 0));
            var matched,
                ops = [];

            for (var i = 0, matchIndex = 0, regexStr = ""; i < format.length; i++) {
              var token = format[i];
              var isBackSlash = token === "\\";
              var escaped = format[i - 1] === "\\" || isBackSlash;

              if (tokenRegex[token] && !escaped) {
                regexStr += tokenRegex[token];
                var match = new RegExp(regexStr).exec(date);

                if (match && (matched = true)) {
                  ops[token !== "Y" ? "push" : "unshift"]({
                    fn: revFormat[token],
                    val: match[++matchIndex]
                  });
                }
              } else if (!isBackSlash) regexStr += ".";

              ops.forEach(function (_ref3) {
                var fn = _ref3.fn,
                    val = _ref3.val;
                return parsedDate = fn(parsedDate, val, locale) || parsedDate;
              });
            }

            parsedDate = matched ? parsedDate : undefined;
          }
        }

        if (!(parsedDate instanceof Date && !isNaN(parsedDate.getTime()))) {
          config.errorHandler(new Error("Invalid date provided: " + date_orig));
          return undefined;
        }

        if (timeless === true) parsedDate.setHours(0, 0, 0, 0);
        return parsedDate;
      };
    };
    function compareDates(date1, date2, timeless) {
      if (timeless === void 0) {
        timeless = true;
      }

      if (timeless !== false) {
        return new Date(date1.getTime()).setHours(0, 0, 0, 0) - new Date(date2.getTime()).setHours(0, 0, 0, 0);
      }

      return date1.getTime() - date2.getTime();
    }
    var getWeek = function getWeek(givenDate) {
      var date = new Date(givenDate.getTime());
      date.setHours(0, 0, 0, 0);
      date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
      var week1 = new Date(date.getFullYear(), 0, 4);
      return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
    };
    var isBetween = function isBetween(ts, ts1, ts2) {
      return ts > Math.min(ts1, ts2) && ts < Math.max(ts1, ts2);
    };
    var duration = {
      DAY: 86400000
    };

    var HOOKS = ["onChange", "onClose", "onDayCreate", "onDestroy", "onKeyDown", "onMonthChange", "onOpen", "onParseConfig", "onReady", "onValueUpdate", "onYearChange", "onPreCalendarPosition"];
    var defaults = {
      _disable: [],
      _enable: [],
      allowInput: false,
      altFormat: "F j, Y",
      altInput: false,
      altInputClass: "form-control input",
      animate: typeof window === "object" && window.navigator.userAgent.indexOf("MSIE") === -1,
      ariaDateFormat: "F j, Y",
      clickOpens: true,
      closeOnSelect: true,
      conjunction: ", ",
      dateFormat: "Y-m-d",
      defaultHour: 12,
      defaultMinute: 0,
      defaultSeconds: 0,
      disable: [],
      disableMobile: false,
      enable: [],
      enableSeconds: false,
      enableTime: false,
      errorHandler: function errorHandler(err) {
        return typeof console !== "undefined" && console.warn(err);
      },
      getWeek: getWeek,
      hourIncrement: 1,
      ignoredFocusElements: [],
      inline: false,
      locale: "default",
      minuteIncrement: 5,
      mode: "single",
      nextArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",
      noCalendar: false,
      now: new Date(),
      onChange: [],
      onClose: [],
      onDayCreate: [],
      onDestroy: [],
      onKeyDown: [],
      onMonthChange: [],
      onOpen: [],
      onParseConfig: [],
      onReady: [],
      onValueUpdate: [],
      onYearChange: [],
      onPreCalendarPosition: [],
      plugins: [],
      position: "auto",
      positionElement: undefined,
      prevArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",
      shorthandCurrentMonth: false,
      showMonths: 1,
      static: false,
      time_24hr: false,
      weekNumbers: false,
      wrap: false
    };

    function toggleClass(elem, className, bool) {
      if (bool === true) return elem.classList.add(className);
      elem.classList.remove(className);
    }
    function createElement(tag, className, content) {
      var e = window.document.createElement(tag);
      className = className || "";
      content = content || "";
      e.className = className;
      if (content !== undefined) e.textContent = content;
      return e;
    }
    function clearNode(node) {
      while (node.firstChild) {
        node.removeChild(node.firstChild);
      }
    }
    function findParent(node, condition) {
      if (condition(node)) return node;else if (node.parentNode) return findParent(node.parentNode, condition);
      return undefined;
    }
    function createNumberInput(inputClassName, opts) {
      var wrapper = createElement("div", "numInputWrapper"),
          numInput = createElement("input", "numInput " + inputClassName),
          arrowUp = createElement("span", "arrowUp"),
          arrowDown = createElement("span", "arrowDown");
      numInput.type = "text";
      numInput.pattern = "\\d*";
      if (opts !== undefined) for (var key in opts) {
        numInput.setAttribute(key, opts[key]);
      }
      wrapper.appendChild(numInput);
      wrapper.appendChild(arrowUp);
      wrapper.appendChild(arrowDown);
      return wrapper;
    }

    if (typeof Object.assign !== "function") {
      Object.assign = function (target) {
        if (!target) {
          throw TypeError("Cannot convert undefined or null to object");
        }

        for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
          args[_key - 1] = arguments[_key];
        }

        var _loop = function _loop() {
          var source = args[_i];

          if (source) {
            Object.keys(source).forEach(function (key) {
              return target[key] = source[key];
            });
          }
        };

        for (var _i = 0; _i < args.length; _i++) {
          _loop();
        }

        return target;
      };
    }

    var DEBOUNCED_CHANGE_MS = 300;

    function FlatpickrInstance(element, instanceConfig) {
      var self = {
        config: Object.assign({}, flatpickr.defaultConfig),
        l10n: english
      };
      self.parseDate = createDateParser({
        config: self.config,
        l10n: self.l10n
      });
      self._handlers = [];
      self._bind = bind;
      self._setHoursFromDate = setHoursFromDate;
      self._positionCalendar = positionCalendar;
      self.changeMonth = changeMonth;
      self.changeYear = changeYear;
      self.clear = clear;
      self.close = close;
      self._createElement = createElement;
      self.destroy = destroy;
      self.isEnabled = isEnabled;
      self.jumpToDate = jumpToDate;
      self.open = open;
      self.redraw = redraw;
      self.set = set;
      self.setDate = setDate;
      self.toggle = toggle;

      function setupHelperFunctions() {
        self.utils = {
          getDaysInMonth: function getDaysInMonth(month, yr) {
            if (month === void 0) {
              month = self.currentMonth;
            }

            if (yr === void 0) {
              yr = self.currentYear;
            }

            if (month === 1 && (yr % 4 === 0 && yr % 100 !== 0 || yr % 400 === 0)) return 29;
            return self.l10n.daysInMonth[month];
          }
        };
      }

      function init() {
        self.element = self.input = element;
        self.isOpen = false;
        parseConfig();
        setupLocale();
        setupInputs();
        setupDates();
        setupHelperFunctions();
        if (!self.isMobile) build();
        bindEvents();

        if (self.selectedDates.length || self.config.noCalendar) {
          if (self.config.enableTime) {
            setHoursFromDate(self.config.noCalendar ? self.latestSelectedDateObj || self.config.minDate : undefined);
          }

          updateValue(false);
        }

        setCalendarWidth();
        self.showTimeInput = self.selectedDates.length > 0 || self.config.noCalendar;
        var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

        if (!self.isMobile && isSafari) {
          positionCalendar();
        }

        triggerEvent("onReady");
      }

      function bindToInstance(fn) {
        return fn.bind(self);
      }

      function setCalendarWidth() {
        var config = self.config;
        if (config.weekNumbers === false && config.showMonths === 1) return;else if (config.noCalendar !== true) {
          window.requestAnimationFrame(function () {
            self.calendarContainer.style.visibility = "hidden";
            self.calendarContainer.style.display = "block";

            if (self.daysContainer !== undefined) {
              var daysWidth = (self.days.offsetWidth + 1) * config.showMonths;
              self.daysContainer.style.width = daysWidth + "px";
              self.calendarContainer.style.width = daysWidth + (self.weekWrapper !== undefined ? self.weekWrapper.offsetWidth : 0) + "px";
              self.calendarContainer.style.removeProperty("visibility");
              self.calendarContainer.style.removeProperty("display");
            }
          });
        }
      }

      function updateTime(e) {
        if (self.selectedDates.length === 0) return;

        if (e !== undefined && e.type !== "blur") {
          timeWrapper(e);
        }

        var prevValue = self._input.value;
        setHoursFromInputs();
        updateValue();

        if (self._input.value !== prevValue) {
          self._debouncedChange();
        }
      }

      function ampm2military(hour, amPM) {
        return hour % 12 + 12 * int(amPM === self.l10n.amPM[1]);
      }

      function military2ampm(hour) {
        switch (hour % 24) {
          case 0:
          case 12:
            return 12;

          default:
            return hour % 12;
        }
      }

      function setHoursFromInputs() {
        if (self.hourElement === undefined || self.minuteElement === undefined) return;
        var hours = (parseInt(self.hourElement.value.slice(-2), 10) || 0) % 24,
            minutes = (parseInt(self.minuteElement.value, 10) || 0) % 60,
            seconds = self.secondElement !== undefined ? (parseInt(self.secondElement.value, 10) || 0) % 60 : 0;

        if (self.amPM !== undefined) {
          hours = ampm2military(hours, self.amPM.textContent);
        }

        var limitMinHours = self.config.minTime !== undefined || self.config.minDate && self.minDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.minDate, true) === 0;
        var limitMaxHours = self.config.maxTime !== undefined || self.config.maxDate && self.maxDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.maxDate, true) === 0;

        if (limitMaxHours) {
          var maxTime = self.config.maxTime !== undefined ? self.config.maxTime : self.config.maxDate;
          hours = Math.min(hours, maxTime.getHours());
          if (hours === maxTime.getHours()) minutes = Math.min(minutes, maxTime.getMinutes());
          if (minutes === maxTime.getMinutes()) seconds = Math.min(seconds, maxTime.getSeconds());
        }

        if (limitMinHours) {
          var minTime = self.config.minTime !== undefined ? self.config.minTime : self.config.minDate;
          hours = Math.max(hours, minTime.getHours());
          if (hours === minTime.getHours()) minutes = Math.max(minutes, minTime.getMinutes());
          if (minutes === minTime.getMinutes()) seconds = Math.max(seconds, minTime.getSeconds());
        }

        setHours(hours, minutes, seconds);
      }

      function setHoursFromDate(dateObj) {
        var date = dateObj || self.latestSelectedDateObj;
        if (date) setHours(date.getHours(), date.getMinutes(), date.getSeconds());
      }

      function setDefaultHours() {
        var hours = self.config.defaultHour;
        var minutes = self.config.defaultMinute;
        var seconds = self.config.defaultSeconds;

        if (self.config.minDate !== undefined) {
          var min_hr = self.config.minDate.getHours();
          var min_minutes = self.config.minDate.getMinutes();
          hours = Math.max(hours, min_hr);
          if (hours === min_hr) minutes = Math.max(min_minutes, minutes);
          if (hours === min_hr && minutes === min_minutes) seconds = self.config.minDate.getSeconds();
        }

        if (self.config.maxDate !== undefined) {
          var max_hr = self.config.maxDate.getHours();
          var max_minutes = self.config.maxDate.getMinutes();
          hours = Math.min(hours, max_hr);
          if (hours === max_hr) minutes = Math.min(max_minutes, minutes);
          if (hours === max_hr && minutes === max_minutes) seconds = self.config.maxDate.getSeconds();
        }

        setHours(hours, minutes, seconds);
      }

      function setHours(hours, minutes, seconds) {
        if (self.latestSelectedDateObj !== undefined) {
          self.latestSelectedDateObj.setHours(hours % 24, minutes, seconds || 0, 0);
        }

        if (!self.hourElement || !self.minuteElement || self.isMobile) return;
        self.hourElement.value = pad(!self.config.time_24hr ? (12 + hours) % 12 + 12 * int(hours % 12 === 0) : hours);
        self.minuteElement.value = pad(minutes);
        if (self.amPM !== undefined) self.amPM.textContent = self.l10n.amPM[int(hours >= 12)];
        if (self.secondElement !== undefined) self.secondElement.value = pad(seconds);
      }

      function onYearInput(event) {
        var year = parseInt(event.target.value) + (event.delta || 0);

        if (year / 1000 > 1 || event.key === "Enter" && !/[^\d]/.test(year.toString())) {
          changeYear(year);
        }
      }

      function bind(element, event, handler, options) {
        if (event instanceof Array) return event.forEach(function (ev) {
          return bind(element, ev, handler, options);
        });
        if (element instanceof Array) return element.forEach(function (el) {
          return bind(el, event, handler, options);
        });
        element.addEventListener(event, handler, options);

        self._handlers.push({
          element: element,
          event: event,
          handler: handler,
          options: options
        });
      }

      function onClick(handler) {
        return function (evt) {
          evt.which === 1 && handler(evt);
        };
      }

      function triggerChange() {
        triggerEvent("onChange");
      }

      function bindEvents() {
        if (self.config.wrap) {
          ["open", "close", "toggle", "clear"].forEach(function (evt) {
            Array.prototype.forEach.call(self.element.querySelectorAll("[data-" + evt + "]"), function (el) {
              return bind(el, "click", self[evt]);
            });
          });
        }

        if (self.isMobile) {
          setupMobile();
          return;
        }

        var debouncedResize = debounce(onResize, 50);
        self._debouncedChange = debounce(triggerChange, DEBOUNCED_CHANGE_MS);
        if (self.daysContainer && !/iPhone|iPad|iPod/i.test(navigator.userAgent)) bind(self.daysContainer, "mouseover", function (e) {
          if (self.config.mode === "range") onMouseOver(e.target);
        });
        bind(window.document.body, "keydown", onKeyDown);
        if (!self.config.static) bind(self._input, "keydown", onKeyDown);
        if (!self.config.inline && !self.config.static) bind(window, "resize", debouncedResize);
        if (window.ontouchstart !== undefined) bind(window.document, "click", documentClick);else bind(window.document, "mousedown", onClick(documentClick));
        bind(window.document, "focus", documentClick, {
          capture: true
        });

        if (self.config.clickOpens === true) {
          bind(self._input, "focus", self.open);
          bind(self._input, "mousedown", onClick(self.open));
        }

        if (self.daysContainer !== undefined) {
          bind(self.monthNav, "mousedown", onClick(onMonthNavClick));
          bind(self.monthNav, ["keyup", "increment"], onYearInput);
          bind(self.daysContainer, "mousedown", onClick(selectDate));
        }

        if (self.timeContainer !== undefined && self.minuteElement !== undefined && self.hourElement !== undefined) {
          var selText = function selText(e) {
            return e.target.select();
          };

          bind(self.timeContainer, ["increment"], updateTime);
          bind(self.timeContainer, "blur", updateTime, {
            capture: true
          });
          bind(self.timeContainer, "mousedown", onClick(timeIncrement));
          bind([self.hourElement, self.minuteElement], ["focus", "click"], selText);
          if (self.secondElement !== undefined) bind(self.secondElement, "focus", function () {
            return self.secondElement && self.secondElement.select();
          });

          if (self.amPM !== undefined) {
            bind(self.amPM, "mousedown", onClick(function (e) {
              updateTime(e);
              triggerChange();
            }));
          }
        }
      }

      function jumpToDate(jumpDate) {
        var jumpTo = jumpDate !== undefined ? self.parseDate(jumpDate) : self.latestSelectedDateObj || (self.config.minDate && self.config.minDate > self.now ? self.config.minDate : self.config.maxDate && self.config.maxDate < self.now ? self.config.maxDate : self.now);

        try {
          if (jumpTo !== undefined) {
            self.currentYear = jumpTo.getFullYear();
            self.currentMonth = jumpTo.getMonth();
          }
        } catch (e) {
          e.message = "Invalid date supplied: " + jumpTo;
          self.config.errorHandler(e);
        }

        self.redraw();
      }

      function timeIncrement(e) {
        if (~e.target.className.indexOf("arrow")) incrementNumInput(e, e.target.classList.contains("arrowUp") ? 1 : -1);
      }

      function incrementNumInput(e, delta, inputElem) {
        var target = e && e.target;
        var input = inputElem || target && target.parentNode && target.parentNode.firstChild;
        var event = createEvent("increment");
        event.delta = delta;
        input && input.dispatchEvent(event);
      }

      function build() {
        var fragment = window.document.createDocumentFragment();
        self.calendarContainer = createElement("div", "flatpickr-calendar");
        self.calendarContainer.tabIndex = -1;

        if (!self.config.noCalendar) {
          fragment.appendChild(buildMonthNav());
          self.innerContainer = createElement("div", "flatpickr-innerContainer");

          if (self.config.weekNumbers) {
            var _buildWeeks = buildWeeks(),
                weekWrapper = _buildWeeks.weekWrapper,
                weekNumbers = _buildWeeks.weekNumbers;

            self.innerContainer.appendChild(weekWrapper);
            self.weekNumbers = weekNumbers;
            self.weekWrapper = weekWrapper;
          }

          self.rContainer = createElement("div", "flatpickr-rContainer");
          self.rContainer.appendChild(buildWeekdays());

          if (!self.daysContainer) {
            self.daysContainer = createElement("div", "flatpickr-days");
            self.daysContainer.tabIndex = -1;
          }

          buildDays();
          self.rContainer.appendChild(self.daysContainer);
          self.innerContainer.appendChild(self.rContainer);
          fragment.appendChild(self.innerContainer);
        }

        if (self.config.enableTime) {
          fragment.appendChild(buildTime());
        }

        toggleClass(self.calendarContainer, "rangeMode", self.config.mode === "range");
        toggleClass(self.calendarContainer, "animate", self.config.animate === true);
        toggleClass(self.calendarContainer, "multiMonth", self.config.showMonths > 1);
        self.calendarContainer.appendChild(fragment);
        var customAppend = self.config.appendTo !== undefined && self.config.appendTo.nodeType !== undefined;

        if (self.config.inline || self.config.static) {
          self.calendarContainer.classList.add(self.config.inline ? "inline" : "static");

          if (self.config.inline) {
            if (!customAppend && self.element.parentNode) self.element.parentNode.insertBefore(self.calendarContainer, self._input.nextSibling);else if (self.config.appendTo !== undefined) self.config.appendTo.appendChild(self.calendarContainer);
          }

          if (self.config.static) {
            var wrapper = createElement("div", "flatpickr-wrapper");
            if (self.element.parentNode) self.element.parentNode.insertBefore(wrapper, self.element);
            wrapper.appendChild(self.element);
            if (self.altInput) wrapper.appendChild(self.altInput);
            wrapper.appendChild(self.calendarContainer);
          }
        }

        if (!self.config.static && !self.config.inline) (self.config.appendTo !== undefined ? self.config.appendTo : window.document.body).appendChild(self.calendarContainer);
      }

      function createDay(className, date, dayNumber, i) {
        var dateIsEnabled = isEnabled(date, true),
            dayElement = createElement("span", "flatpickr-day " + className, date.getDate().toString());
        dayElement.dateObj = date;
        dayElement.$i = i;
        dayElement.setAttribute("aria-label", self.formatDate(date, self.config.ariaDateFormat));

        if (className.indexOf("hidden") === -1 && compareDates(date, self.now) === 0) {
          self.todayDateElem = dayElement;
          dayElement.classList.add("today");
          dayElement.setAttribute("aria-current", "date");
        }

        if (dateIsEnabled) {
          dayElement.tabIndex = -1;

          if (isDateSelected(date)) {
            dayElement.classList.add("selected");
            self.selectedDateElem = dayElement;

            if (self.config.mode === "range") {
              toggleClass(dayElement, "startRange", self.selectedDates[0] && compareDates(date, self.selectedDates[0], true) === 0);
              toggleClass(dayElement, "endRange", self.selectedDates[1] && compareDates(date, self.selectedDates[1], true) === 0);
              if (className === "nextMonthDay") dayElement.classList.add("inRange");
            }
          }
        } else {
          dayElement.classList.add("disabled");
        }

        if (self.config.mode === "range") {
          if (isDateInRange(date) && !isDateSelected(date)) dayElement.classList.add("inRange");
        }

        if (self.weekNumbers && self.config.showMonths === 1 && className !== "prevMonthDay" && dayNumber % 7 === 1) {
          self.weekNumbers.insertAdjacentHTML("beforeend", "<span class='flatpickr-day'>" + self.config.getWeek(date) + "</span>");
        }

        triggerEvent("onDayCreate", dayElement);
        return dayElement;
      }

      function focusOnDayElem(targetNode) {
        targetNode.focus();
        if (self.config.mode === "range") onMouseOver(targetNode);
      }

      function getFirstAvailableDay(delta) {
        var startMonth = delta > 0 ? 0 : self.config.showMonths - 1;
        var endMonth = delta > 0 ? self.config.showMonths : -1;

        for (var m = startMonth; m != endMonth; m += delta) {
          var month = self.daysContainer.children[m];
          var startIndex = delta > 0 ? 0 : month.children.length - 1;
          var endIndex = delta > 0 ? month.children.length : -1;

          for (var i = startIndex; i != endIndex; i += delta) {
            var c = month.children[i];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj)) return c;
          }
        }

        return undefined;
      }

      function getNextAvailableDay(current, delta) {
        var givenMonth = current.className.indexOf("Month") === -1 ? current.dateObj.getMonth() : self.currentMonth;
        var endMonth = delta > 0 ? self.config.showMonths : -1;
        var loopDelta = delta > 0 ? 1 : -1;

        for (var m = givenMonth - self.currentMonth; m != endMonth; m += loopDelta) {
          var month = self.daysContainer.children[m];
          var startIndex = givenMonth - self.currentMonth === m ? current.$i + delta : delta < 0 ? month.children.length - 1 : 0;
          var numMonthDays = month.children.length;

          for (var i = startIndex; i >= 0 && i < numMonthDays && i != (delta > 0 ? numMonthDays : -1); i += loopDelta) {
            var c = month.children[i];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj) && Math.abs(current.$i - i) >= Math.abs(delta)) return focusOnDayElem(c);
          }
        }

        self.changeMonth(loopDelta);
        focusOnDay(getFirstAvailableDay(loopDelta), 0);
        return undefined;
      }

      function focusOnDay(current, offset) {
        var dayFocused = isInView(document.activeElement || document.body);
        var startElem = current !== undefined ? current : dayFocused ? document.activeElement : self.selectedDateElem !== undefined && isInView(self.selectedDateElem) ? self.selectedDateElem : self.todayDateElem !== undefined && isInView(self.todayDateElem) ? self.todayDateElem : getFirstAvailableDay(offset > 0 ? 1 : -1);
        if (startElem === undefined) return self._input.focus();
        if (!dayFocused) return focusOnDayElem(startElem);
        getNextAvailableDay(startElem, offset);
      }

      function buildMonthDays(year, month) {
        var firstOfMonth = (new Date(year, month, 1).getDay() - self.l10n.firstDayOfWeek + 7) % 7;
        var prevMonthDays = self.utils.getDaysInMonth((month - 1 + 12) % 12);
        var daysInMonth = self.utils.getDaysInMonth(month),
            days = window.document.createDocumentFragment(),
            isMultiMonth = self.config.showMonths > 1,
            prevMonthDayClass = isMultiMonth ? "prevMonthDay hidden" : "prevMonthDay",
            nextMonthDayClass = isMultiMonth ? "nextMonthDay hidden" : "nextMonthDay";
        var dayNumber = prevMonthDays + 1 - firstOfMonth,
            dayIndex = 0;

        for (; dayNumber <= prevMonthDays; dayNumber++, dayIndex++) {
          days.appendChild(createDay(prevMonthDayClass, new Date(year, month - 1, dayNumber), dayNumber, dayIndex));
        }

        for (dayNumber = 1; dayNumber <= daysInMonth; dayNumber++, dayIndex++) {
          days.appendChild(createDay("", new Date(year, month, dayNumber), dayNumber, dayIndex));
        }

        for (var dayNum = daysInMonth + 1; dayNum <= 42 - firstOfMonth && (self.config.showMonths === 1 || dayIndex % 7 !== 0); dayNum++, dayIndex++) {
          days.appendChild(createDay(nextMonthDayClass, new Date(year, month + 1, dayNum % daysInMonth), dayNum, dayIndex));
        }

        var dayContainer = createElement("div", "dayContainer");
        dayContainer.appendChild(days);
        return dayContainer;
      }

      function buildDays() {
        if (self.daysContainer === undefined) {
          return;
        }

        clearNode(self.daysContainer);
        if (self.weekNumbers) clearNode(self.weekNumbers);
        var frag = document.createDocumentFragment();

        for (var i = 0; i < self.config.showMonths; i++) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i);
          frag.appendChild(buildMonthDays(d.getFullYear(), d.getMonth()));
        }

        self.daysContainer.appendChild(frag);
        self.days = self.daysContainer.firstChild;

        if (self.config.mode === "range" && self.selectedDates.length === 1) {
          onMouseOver();
        }
      }

      function buildMonth() {
        var container = createElement("div", "flatpickr-month");
        var monthNavFragment = window.document.createDocumentFragment();
        var monthElement = createElement("span", "cur-month");
        var yearInput = createNumberInput("cur-year", {
          tabindex: "-1"
        });
        var yearElement = yearInput.getElementsByTagName("input")[0];
        yearElement.setAttribute("aria-label", self.l10n.yearAriaLabel);
        if (self.config.minDate) yearElement.setAttribute("data-min", self.config.minDate.getFullYear().toString());

        if (self.config.maxDate) {
          yearElement.setAttribute("data-max", self.config.maxDate.getFullYear().toString());
          yearElement.disabled = !!self.config.minDate && self.config.minDate.getFullYear() === self.config.maxDate.getFullYear();
        }

        var currentMonth = createElement("div", "flatpickr-current-month");
        currentMonth.appendChild(monthElement);
        currentMonth.appendChild(yearInput);
        monthNavFragment.appendChild(currentMonth);
        container.appendChild(monthNavFragment);
        return {
          container: container,
          yearElement: yearElement,
          monthElement: monthElement
        };
      }

      function buildMonths() {
        clearNode(self.monthNav);
        self.monthNav.appendChild(self.prevMonthNav);

        for (var m = self.config.showMonths; m--;) {
          var month = buildMonth();
          self.yearElements.push(month.yearElement);
          self.monthElements.push(month.monthElement);
          self.monthNav.appendChild(month.container);
        }

        self.monthNav.appendChild(self.nextMonthNav);
      }

      function buildMonthNav() {
        self.monthNav = createElement("div", "flatpickr-months");
        self.yearElements = [];
        self.monthElements = [];
        self.prevMonthNav = createElement("span", "flatpickr-prev-month");
        self.prevMonthNav.innerHTML = self.config.prevArrow;
        self.nextMonthNav = createElement("span", "flatpickr-next-month");
        self.nextMonthNav.innerHTML = self.config.nextArrow;
        buildMonths();
        Object.defineProperty(self, "_hidePrevMonthArrow", {
          get: function get() {
            return self.__hidePrevMonthArrow;
          },
          set: function set(bool) {
            if (self.__hidePrevMonthArrow !== bool) {
              toggleClass(self.prevMonthNav, "disabled", bool);
              self.__hidePrevMonthArrow = bool;
            }
          }
        });
        Object.defineProperty(self, "_hideNextMonthArrow", {
          get: function get() {
            return self.__hideNextMonthArrow;
          },
          set: function set(bool) {
            if (self.__hideNextMonthArrow !== bool) {
              toggleClass(self.nextMonthNav, "disabled", bool);
              self.__hideNextMonthArrow = bool;
            }
          }
        });
        self.currentYearElement = self.yearElements[0];
        updateNavigationCurrentMonth();
        return self.monthNav;
      }

      function buildTime() {
        self.calendarContainer.classList.add("hasTime");
        if (self.config.noCalendar) self.calendarContainer.classList.add("noCalendar");
        self.timeContainer = createElement("div", "flatpickr-time");
        self.timeContainer.tabIndex = -1;
        var separator = createElement("span", "flatpickr-time-separator", ":");
        var hourInput = createNumberInput("flatpickr-hour");
        self.hourElement = hourInput.getElementsByTagName("input")[0];
        var minuteInput = createNumberInput("flatpickr-minute");
        self.minuteElement = minuteInput.getElementsByTagName("input")[0];
        self.hourElement.tabIndex = self.minuteElement.tabIndex = -1;
        self.hourElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getHours() : self.config.time_24hr ? self.config.defaultHour : military2ampm(self.config.defaultHour));
        self.minuteElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getMinutes() : self.config.defaultMinute);
        self.hourElement.setAttribute("data-step", self.config.hourIncrement.toString());
        self.minuteElement.setAttribute("data-step", self.config.minuteIncrement.toString());
        self.hourElement.setAttribute("data-min", self.config.time_24hr ? "0" : "1");
        self.hourElement.setAttribute("data-max", self.config.time_24hr ? "23" : "12");
        self.minuteElement.setAttribute("data-min", "0");
        self.minuteElement.setAttribute("data-max", "59");
        self.timeContainer.appendChild(hourInput);
        self.timeContainer.appendChild(separator);
        self.timeContainer.appendChild(minuteInput);
        if (self.config.time_24hr) self.timeContainer.classList.add("time24hr");

        if (self.config.enableSeconds) {
          self.timeContainer.classList.add("hasSeconds");
          var secondInput = createNumberInput("flatpickr-second");
          self.secondElement = secondInput.getElementsByTagName("input")[0];
          self.secondElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getSeconds() : self.config.defaultSeconds);
          self.secondElement.setAttribute("data-step", self.minuteElement.getAttribute("data-step"));
          self.secondElement.setAttribute("data-min", self.minuteElement.getAttribute("data-min"));
          self.secondElement.setAttribute("data-max", self.minuteElement.getAttribute("data-max"));
          self.timeContainer.appendChild(createElement("span", "flatpickr-time-separator", ":"));
          self.timeContainer.appendChild(secondInput);
        }

        if (!self.config.time_24hr) {
          self.amPM = createElement("span", "flatpickr-am-pm", self.l10n.amPM[int((self.latestSelectedDateObj ? self.hourElement.value : self.config.defaultHour) > 11)]);
          self.amPM.title = self.l10n.toggleTitle;
          self.amPM.tabIndex = -1;
          self.timeContainer.appendChild(self.amPM);
        }

        return self.timeContainer;
      }

      function buildWeekdays() {
        if (!self.weekdayContainer) self.weekdayContainer = createElement("div", "flatpickr-weekdays");else clearNode(self.weekdayContainer);

        for (var i = self.config.showMonths; i--;) {
          var container = createElement("div", "flatpickr-weekdaycontainer");
          self.weekdayContainer.appendChild(container);
        }

        updateWeekdays();
        return self.weekdayContainer;
      }

      function updateWeekdays() {
        var firstDayOfWeek = self.l10n.firstDayOfWeek;
        var weekdays = self.l10n.weekdays.shorthand.concat();

        if (firstDayOfWeek > 0 && firstDayOfWeek < weekdays.length) {
          weekdays = weekdays.splice(firstDayOfWeek, weekdays.length).concat(weekdays.splice(0, firstDayOfWeek));
        }

        for (var i = self.config.showMonths; i--;) {
          self.weekdayContainer.children[i].innerHTML = "\n      <span class=flatpickr-weekday>\n        " + weekdays.join("</span><span class=flatpickr-weekday>") + "\n      </span>\n      ";
        }
      }

      function buildWeeks() {
        self.calendarContainer.classList.add("hasWeeks");
        var weekWrapper = createElement("div", "flatpickr-weekwrapper");
        weekWrapper.appendChild(createElement("span", "flatpickr-weekday", self.l10n.weekAbbreviation));
        var weekNumbers = createElement("div", "flatpickr-weeks");
        weekWrapper.appendChild(weekNumbers);
        return {
          weekWrapper: weekWrapper,
          weekNumbers: weekNumbers
        };
      }

      function changeMonth(value, is_offset) {
        if (is_offset === void 0) {
          is_offset = true;
        }

        var delta = is_offset ? value : value - self.currentMonth;
        if (delta < 0 && self._hidePrevMonthArrow === true || delta > 0 && self._hideNextMonthArrow === true) return;
        self.currentMonth += delta;

        if (self.currentMonth < 0 || self.currentMonth > 11) {
          self.currentYear += self.currentMonth > 11 ? 1 : -1;
          self.currentMonth = (self.currentMonth + 12) % 12;
          triggerEvent("onYearChange");
        }

        buildDays();
        triggerEvent("onMonthChange");
        updateNavigationCurrentMonth();
      }

      function clear(triggerChangeEvent) {
        if (triggerChangeEvent === void 0) {
          triggerChangeEvent = true;
        }

        self.input.value = "";
        if (self.altInput !== undefined) self.altInput.value = "";
        if (self.mobileInput !== undefined) self.mobileInput.value = "";
        self.selectedDates = [];
        self.latestSelectedDateObj = undefined;
        self.showTimeInput = false;

        if (self.config.enableTime === true) {
          setDefaultHours();
        }

        self.redraw();
        if (triggerChangeEvent) triggerEvent("onChange");
      }

      function close() {
        self.isOpen = false;

        if (!self.isMobile) {
          self.calendarContainer.classList.remove("open");

          self._input.classList.remove("active");
        }

        triggerEvent("onClose");
      }

      function destroy() {
        if (self.config !== undefined) triggerEvent("onDestroy");

        for (var i = self._handlers.length; i--;) {
          var h = self._handlers[i];
          h.element.removeEventListener(h.event, h.handler, h.options);
        }

        self._handlers = [];

        if (self.mobileInput) {
          if (self.mobileInput.parentNode) self.mobileInput.parentNode.removeChild(self.mobileInput);
          self.mobileInput = undefined;
        } else if (self.calendarContainer && self.calendarContainer.parentNode) {
          if (self.config.static && self.calendarContainer.parentNode) {
            var wrapper = self.calendarContainer.parentNode;
            wrapper.lastChild && wrapper.removeChild(wrapper.lastChild);

            if (wrapper.parentNode) {
              while (wrapper.firstChild) {
                wrapper.parentNode.insertBefore(wrapper.firstChild, wrapper);
              }

              wrapper.parentNode.removeChild(wrapper);
            }
          } else self.calendarContainer.parentNode.removeChild(self.calendarContainer);
        }

        if (self.altInput) {
          self.input.type = "text";
          if (self.altInput.parentNode) self.altInput.parentNode.removeChild(self.altInput);
          delete self.altInput;
        }

        if (self.input) {
          self.input.type = self.input._type;
          self.input.classList.remove("flatpickr-input");
          self.input.removeAttribute("readonly");
          self.input.value = "";
        }

        ["_showTimeInput", "latestSelectedDateObj", "_hideNextMonthArrow", "_hidePrevMonthArrow", "__hideNextMonthArrow", "__hidePrevMonthArrow", "isMobile", "isOpen", "selectedDateElem", "minDateHasTime", "maxDateHasTime", "days", "daysContainer", "_input", "_positionElement", "innerContainer", "rContainer", "monthNav", "todayDateElem", "calendarContainer", "weekdayContainer", "prevMonthNav", "nextMonthNav", "currentMonthElement", "currentYearElement", "navigationCurrentMonth", "selectedDateElem", "config"].forEach(function (k) {
          try {
            delete self[k];
          } catch (_) {}
        });
      }

      function isCalendarElem(elem) {
        if (self.config.appendTo && self.config.appendTo.contains(elem)) return true;
        return self.calendarContainer.contains(elem);
      }

      function documentClick(e) {
        if (self.isOpen && !self.config.inline) {
          var isCalendarElement = isCalendarElem(e.target);
          var isInput = e.target === self.input || e.target === self.altInput || self.element.contains(e.target) || e.path && e.path.indexOf && (~e.path.indexOf(self.input) || ~e.path.indexOf(self.altInput));
          var lostFocus = e.type === "blur" ? isInput && e.relatedTarget && !isCalendarElem(e.relatedTarget) : !isInput && !isCalendarElement;
          var isIgnored = !self.config.ignoredFocusElements.some(function (elem) {
            return elem.contains(e.target);
          });

          if (lostFocus && isIgnored) {
            self.close();

            if (self.config.mode === "range" && self.selectedDates.length === 1) {
              self.clear(false);
              self.redraw();
            }
          }
        }
      }

      function changeYear(newYear) {
        if (!newYear || self.config.minDate && newYear < self.config.minDate.getFullYear() || self.config.maxDate && newYear > self.config.maxDate.getFullYear()) return;
        var newYearNum = newYear,
            isNewYear = self.currentYear !== newYearNum;
        self.currentYear = newYearNum || self.currentYear;

        if (self.config.maxDate && self.currentYear === self.config.maxDate.getFullYear()) {
          self.currentMonth = Math.min(self.config.maxDate.getMonth(), self.currentMonth);
        } else if (self.config.minDate && self.currentYear === self.config.minDate.getFullYear()) {
          self.currentMonth = Math.max(self.config.minDate.getMonth(), self.currentMonth);
        }

        if (isNewYear) {
          self.redraw();
          triggerEvent("onYearChange");
        }
      }

      function isEnabled(date, timeless) {
        if (timeless === void 0) {
          timeless = true;
        }

        var dateToCheck = self.parseDate(date, undefined, timeless);
        if (self.config.minDate && dateToCheck && compareDates(dateToCheck, self.config.minDate, timeless !== undefined ? timeless : !self.minDateHasTime) < 0 || self.config.maxDate && dateToCheck && compareDates(dateToCheck, self.config.maxDate, timeless !== undefined ? timeless : !self.maxDateHasTime) > 0) return false;
        if (self.config.enable.length === 0 && self.config.disable.length === 0) return true;
        if (dateToCheck === undefined) return false;
        var bool = self.config.enable.length > 0,
            array = bool ? self.config.enable : self.config.disable;

        for (var i = 0, d; i < array.length; i++) {
          d = array[i];
          if (typeof d === "function" && d(dateToCheck)) return bool;else if (d instanceof Date && dateToCheck !== undefined && d.getTime() === dateToCheck.getTime()) return bool;else if (typeof d === "string" && dateToCheck !== undefined) {
            var parsed = self.parseDate(d, undefined, true);
            return parsed && parsed.getTime() === dateToCheck.getTime() ? bool : !bool;
          } else if (typeof d === "object" && dateToCheck !== undefined && d.from && d.to && dateToCheck.getTime() >= d.from.getTime() && dateToCheck.getTime() <= d.to.getTime()) return bool;
        }

        return !bool;
      }

      function isInView(elem) {
        if (self.daysContainer !== undefined) return elem.className.indexOf("hidden") === -1 && self.daysContainer.contains(elem);
        return false;
      }

      function onKeyDown(e) {
        var isInput = e.target === self._input;
        var allowInput = self.config.allowInput;
        var allowKeydown = self.isOpen && (!allowInput || !isInput);
        var allowInlineKeydown = self.config.inline && isInput && !allowInput;

        if (e.keyCode === 13 && isInput) {
          if (allowInput) {
            self.setDate(self._input.value, true, e.target === self.altInput ? self.config.altFormat : self.config.dateFormat);
            return e.target.blur();
          } else self.open();
        } else if (isCalendarElem(e.target) || allowKeydown || allowInlineKeydown) {
          var isTimeObj = !!self.timeContainer && self.timeContainer.contains(e.target);

          switch (e.keyCode) {
            case 13:
              if (isTimeObj) updateTime();else selectDate(e);
              break;

            case 27:
              e.preventDefault();
              focusAndClose();
              break;

            case 8:
            case 46:
              if (isInput && !self.config.allowInput) {
                e.preventDefault();
                self.clear();
              }

              break;

            case 37:
            case 39:
              if (!isTimeObj) {
                e.preventDefault();

                if (self.daysContainer !== undefined && (allowInput === false || isInView(document.activeElement))) {
                  var _delta = e.keyCode === 39 ? 1 : -1;

                  if (!e.ctrlKey) focusOnDay(undefined, _delta);else {
                    changeMonth(_delta);
                    focusOnDay(getFirstAvailableDay(1), 0);
                  }
                }
              } else if (self.hourElement) self.hourElement.focus();

              break;

            case 38:
            case 40:
              e.preventDefault();
              var delta = e.keyCode === 40 ? 1 : -1;

              if (self.daysContainer && e.target.$i !== undefined) {
                if (e.ctrlKey) {
                  changeYear(self.currentYear - delta);
                  focusOnDay(getFirstAvailableDay(1), 0);
                } else if (!isTimeObj) focusOnDay(undefined, delta * 7);
              } else if (self.config.enableTime) {
                if (!isTimeObj && self.hourElement) self.hourElement.focus();
                updateTime(e);

                self._debouncedChange();
              }

              break;

            case 9:
              if (!isTimeObj) {
                self.element.focus();
                break;
              }

              var elems = [self.hourElement, self.minuteElement, self.secondElement, self.amPM].filter(function (x) {
                return x;
              });
              var i = elems.indexOf(e.target);

              if (i !== -1) {
                var target = elems[i + (e.shiftKey ? -1 : 1)];

                if (target !== undefined) {
                  e.preventDefault();
                  target.focus();
                } else {
                  self.element.focus();
                }
              }

              break;

            default:
              break;
          }
        }

        if (self.amPM !== undefined && e.target === self.amPM) {
          switch (e.key) {
            case self.l10n.amPM[0].charAt(0):
            case self.l10n.amPM[0].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[0];
              setHoursFromInputs();
              updateValue();
              break;

            case self.l10n.amPM[1].charAt(0):
            case self.l10n.amPM[1].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[1];
              setHoursFromInputs();
              updateValue();
              break;
          }
        }

        triggerEvent("onKeyDown", e);
      }

      function onMouseOver(elem) {
        if (self.selectedDates.length !== 1 || elem && (!elem.classList.contains("flatpickr-day") || elem.classList.contains("disabled"))) return;
        var hoverDate = elem ? elem.dateObj.getTime() : self.days.firstElementChild.dateObj.getTime(),
            initialDate = self.parseDate(self.selectedDates[0], undefined, true).getTime(),
            rangeStartDate = Math.min(hoverDate, self.selectedDates[0].getTime()),
            rangeEndDate = Math.max(hoverDate, self.selectedDates[0].getTime()),
            lastDate = self.daysContainer.lastChild.lastChild.dateObj.getTime();
        var containsDisabled = false;
        var minRange = 0,
            maxRange = 0;

        for (var t = rangeStartDate; t < lastDate; t += duration.DAY) {
          if (!isEnabled(new Date(t), true)) {
            containsDisabled = containsDisabled || t > rangeStartDate && t < rangeEndDate;
            if (t < initialDate && (!minRange || t > minRange)) minRange = t;else if (t > initialDate && (!maxRange || t < maxRange)) maxRange = t;
          }
        }

        for (var m = 0; m < self.config.showMonths; m++) {
          var month = self.daysContainer.children[m];
          var prevMonth = self.daysContainer.children[m - 1];

          var _loop = function _loop(i, l) {
            var dayElem = month.children[i],
                date = dayElem.dateObj;
            var timestamp = date.getTime();
            var outOfRange = minRange > 0 && timestamp < minRange || maxRange > 0 && timestamp > maxRange;

            if (outOfRange) {
              dayElem.classList.add("notAllowed");
              ["inRange", "startRange", "endRange"].forEach(function (c) {
                dayElem.classList.remove(c);
              });
              return "continue";
            } else if (containsDisabled && !outOfRange) return "continue";

            ["startRange", "inRange", "endRange", "notAllowed"].forEach(function (c) {
              dayElem.classList.remove(c);
            });

            if (elem !== undefined) {
              elem.classList.add(hoverDate < self.selectedDates[0].getTime() ? "startRange" : "endRange");

              if (month.contains(elem) || !(m > 0 && prevMonth && prevMonth.lastChild.dateObj.getTime() >= timestamp)) {
                if (initialDate < hoverDate && timestamp === initialDate) dayElem.classList.add("startRange");else if (initialDate > hoverDate && timestamp === initialDate) dayElem.classList.add("endRange");
                if (timestamp >= minRange && (maxRange === 0 || timestamp <= maxRange) && isBetween(timestamp, initialDate, hoverDate)) dayElem.classList.add("inRange");
              }
            }
          };

          for (var i = 0, l = month.children.length; i < l; i++) {
            var _ret = _loop(i, l);

            if (_ret === "continue") continue;
          }
        }
      }

      function onResize() {
        if (self.isOpen && !self.config.static && !self.config.inline) positionCalendar();
      }

      function open(e, positionElement) {
        if (positionElement === void 0) {
          positionElement = self._positionElement;
        }

        if (self.isMobile === true) {
          if (e) {
            e.preventDefault();
            e.target && e.target.blur();
          }

          if (self.mobileInput !== undefined) {
            self.mobileInput.focus();
            self.mobileInput.click();
          }

          triggerEvent("onOpen");
          return;
        }

        if (self._input.disabled || self.config.inline) return;
        var wasOpen = self.isOpen;
        self.isOpen = true;

        if (!wasOpen) {
          self.calendarContainer.classList.add("open");

          self._input.classList.add("active");

          triggerEvent("onOpen");
          positionCalendar(positionElement);
        }

        if (self.config.enableTime === true && self.config.noCalendar === true) {
          if (self.selectedDates.length === 0) {
            self.setDate(self.config.minDate !== undefined ? new Date(self.config.minDate.getTime()) : new Date(), false);
            setDefaultHours();
            updateValue();
          }

          if (self.config.allowInput === false && (e === undefined || !self.timeContainer.contains(e.relatedTarget))) {
            setTimeout(function () {
              return self.hourElement.select();
            }, 50);
          }
        }
      }

      function minMaxDateSetter(type) {
        return function (date) {
          var dateObj = self.config["_" + type + "Date"] = self.parseDate(date, self.config.dateFormat);
          var inverseDateObj = self.config["_" + (type === "min" ? "max" : "min") + "Date"];

          if (dateObj !== undefined) {
            self[type === "min" ? "minDateHasTime" : "maxDateHasTime"] = dateObj.getHours() > 0 || dateObj.getMinutes() > 0 || dateObj.getSeconds() > 0;
          }

          if (self.selectedDates) {
            self.selectedDates = self.selectedDates.filter(function (d) {
              return isEnabled(d);
            });
            if (!self.selectedDates.length && type === "min") setHoursFromDate(dateObj);
            updateValue();
          }

          if (self.daysContainer) {
            redraw();
            if (dateObj !== undefined) self.currentYearElement[type] = dateObj.getFullYear().toString();else self.currentYearElement.removeAttribute(type);
            self.currentYearElement.disabled = !!inverseDateObj && dateObj !== undefined && inverseDateObj.getFullYear() === dateObj.getFullYear();
          }
        };
      }

      function parseConfig() {
        var boolOpts = ["wrap", "weekNumbers", "allowInput", "clickOpens", "time_24hr", "enableTime", "noCalendar", "altInput", "shorthandCurrentMonth", "inline", "static", "enableSeconds", "disableMobile"];
        var userConfig = Object.assign({}, instanceConfig, JSON.parse(JSON.stringify(element.dataset || {})));
        var formats$$1 = {};
        self.config.parseDate = userConfig.parseDate;
        self.config.formatDate = userConfig.formatDate;
        Object.defineProperty(self.config, "enable", {
          get: function get() {
            return self.config._enable;
          },
          set: function set(dates) {
            self.config._enable = parseDateRules(dates);
          }
        });
        Object.defineProperty(self.config, "disable", {
          get: function get() {
            return self.config._disable;
          },
          set: function set(dates) {
            self.config._disable = parseDateRules(dates);
          }
        });
        var timeMode = userConfig.mode === "time";

        if (!userConfig.dateFormat && (userConfig.enableTime || timeMode)) {
          formats$$1.dateFormat = userConfig.noCalendar || timeMode ? "H:i" + (userConfig.enableSeconds ? ":S" : "") : flatpickr.defaultConfig.dateFormat + " H:i" + (userConfig.enableSeconds ? ":S" : "");
        }

        if (userConfig.altInput && (userConfig.enableTime || timeMode) && !userConfig.altFormat) {
          formats$$1.altFormat = userConfig.noCalendar || timeMode ? "h:i" + (userConfig.enableSeconds ? ":S K" : " K") : flatpickr.defaultConfig.altFormat + (" h:i" + (userConfig.enableSeconds ? ":S" : "") + " K");
        }

        Object.defineProperty(self.config, "minDate", {
          get: function get() {
            return self.config._minDate;
          },
          set: minMaxDateSetter("min")
        });
        Object.defineProperty(self.config, "maxDate", {
          get: function get() {
            return self.config._maxDate;
          },
          set: minMaxDateSetter("max")
        });

        var minMaxTimeSetter = function minMaxTimeSetter(type) {
          return function (val) {
            self.config[type === "min" ? "_minTime" : "_maxTime"] = self.parseDate(val, "H:i");
          };
        };

        Object.defineProperty(self.config, "minTime", {
          get: function get() {
            return self.config._minTime;
          },
          set: minMaxTimeSetter("min")
        });
        Object.defineProperty(self.config, "maxTime", {
          get: function get() {
            return self.config._maxTime;
          },
          set: minMaxTimeSetter("max")
        });

        if (userConfig.mode === "time") {
          self.config.noCalendar = true;
          self.config.enableTime = true;
        }

        Object.assign(self.config, formats$$1, userConfig);

        for (var i = 0; i < boolOpts.length; i++) {
          self.config[boolOpts[i]] = self.config[boolOpts[i]] === true || self.config[boolOpts[i]] === "true";
        }

        HOOKS.filter(function (hook) {
          return self.config[hook] !== undefined;
        }).forEach(function (hook) {
          self.config[hook] = arrayify(self.config[hook] || []).map(bindToInstance);
        });
        self.isMobile = !self.config.disableMobile && !self.config.inline && self.config.mode === "single" && !self.config.disable.length && !self.config.enable.length && !self.config.weekNumbers && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        for (var _i = 0; _i < self.config.plugins.length; _i++) {
          var pluginConf = self.config.plugins[_i](self) || {};

          for (var key in pluginConf) {
            if (HOOKS.indexOf(key) > -1) {
              self.config[key] = arrayify(pluginConf[key]).map(bindToInstance).concat(self.config[key]);
            } else if (typeof userConfig[key] === "undefined") self.config[key] = pluginConf[key];
          }
        }

        triggerEvent("onParseConfig");
      }

      function setupLocale() {
        if (typeof self.config.locale !== "object" && typeof flatpickr.l10ns[self.config.locale] === "undefined") self.config.errorHandler(new Error("flatpickr: invalid locale " + self.config.locale));
        self.l10n = Object.assign({}, flatpickr.l10ns.default, typeof self.config.locale === "object" ? self.config.locale : self.config.locale !== "default" ? flatpickr.l10ns[self.config.locale] : undefined);
        tokenRegex.K = "(" + self.l10n.amPM[0] + "|" + self.l10n.amPM[1] + "|" + self.l10n.amPM[0].toLowerCase() + "|" + self.l10n.amPM[1].toLowerCase() + ")";
        self.formatDate = createDateFormatter(self);
        self.parseDate = createDateParser({
          config: self.config,
          l10n: self.l10n
        });
      }

      function positionCalendar(customPositionElement) {
        if (self.calendarContainer === undefined) return;
        triggerEvent("onPreCalendarPosition");
        var positionElement = customPositionElement || self._positionElement;
        var calendarHeight = Array.prototype.reduce.call(self.calendarContainer.children, function (acc, child) {
          return acc + child.offsetHeight;
        }, 0),
            calendarWidth = self.calendarContainer.offsetWidth,
            configPos = self.config.position.split(" "),
            configPosVertical = configPos[0],
            configPosHorizontal = configPos.length > 1 ? configPos[1] : null,
            inputBounds = positionElement.getBoundingClientRect(),
            distanceFromBottom = window.innerHeight - inputBounds.bottom,
            showOnTop = configPosVertical === "above" || configPosVertical !== "below" && distanceFromBottom < calendarHeight && inputBounds.top > calendarHeight;
        var top = window.pageYOffset + inputBounds.top + (!showOnTop ? positionElement.offsetHeight + 2 : -calendarHeight - 2);
        toggleClass(self.calendarContainer, "arrowTop", !showOnTop);
        toggleClass(self.calendarContainer, "arrowBottom", showOnTop);
        if (self.config.inline) return;
        var left = window.pageXOffset + inputBounds.left - (configPosHorizontal != null && configPosHorizontal === "center" ? (calendarWidth - inputBounds.width) / 2 : 0);
        var right = window.document.body.offsetWidth - inputBounds.right;
        var rightMost = left + calendarWidth > window.document.body.offsetWidth;
        toggleClass(self.calendarContainer, "rightMost", rightMost);
        if (self.config.static) return;
        self.calendarContainer.style.top = top + "px";

        if (!rightMost) {
          self.calendarContainer.style.left = left + "px";
          self.calendarContainer.style.right = "auto";
        } else {
          self.calendarContainer.style.left = "auto";
          self.calendarContainer.style.right = right + "px";
        }
      }

      function redraw() {
        if (self.config.noCalendar || self.isMobile) return;
        updateNavigationCurrentMonth();
        buildDays();
      }

      function focusAndClose() {
        self._input.focus();

        if (window.navigator.userAgent.indexOf("MSIE") !== -1 || navigator.msMaxTouchPoints !== undefined) {
          setTimeout(self.close, 0);
        } else {
          self.close();
        }
      }

      function selectDate(e) {
        e.preventDefault();
        e.stopPropagation();

        var isSelectable = function isSelectable(day) {
          return day.classList && day.classList.contains("flatpickr-day") && !day.classList.contains("disabled") && !day.classList.contains("notAllowed");
        };

        var t = findParent(e.target, isSelectable);
        if (t === undefined) return;
        var target = t;
        var selectedDate = self.latestSelectedDateObj = new Date(target.dateObj.getTime());
        var shouldChangeMonth = (selectedDate.getMonth() < self.currentMonth || selectedDate.getMonth() > self.currentMonth + self.config.showMonths - 1) && self.config.mode !== "range";
        self.selectedDateElem = target;
        if (self.config.mode === "single") self.selectedDates = [selectedDate];else if (self.config.mode === "multiple") {
          var selectedIndex = isDateSelected(selectedDate);
          if (selectedIndex) self.selectedDates.splice(parseInt(selectedIndex), 1);else self.selectedDates.push(selectedDate);
        } else if (self.config.mode === "range") {
          if (self.selectedDates.length === 2) self.clear(false);
          self.selectedDates.push(selectedDate);
          if (compareDates(selectedDate, self.selectedDates[0], true) !== 0) self.selectedDates.sort(function (a, b) {
            return a.getTime() - b.getTime();
          });
        }
        setHoursFromInputs();

        if (shouldChangeMonth) {
          var isNewYear = self.currentYear !== selectedDate.getFullYear();
          self.currentYear = selectedDate.getFullYear();
          self.currentMonth = selectedDate.getMonth();
          if (isNewYear) triggerEvent("onYearChange");
          triggerEvent("onMonthChange");
        }

        updateNavigationCurrentMonth();
        buildDays();
        updateValue();
        if (self.config.enableTime) setTimeout(function () {
          return self.showTimeInput = true;
        }, 50);
        if (!shouldChangeMonth && self.config.mode !== "range" && self.config.showMonths === 1) focusOnDayElem(target);else self.selectedDateElem && self.selectedDateElem.focus();
        if (self.hourElement !== undefined) setTimeout(function () {
          return self.hourElement !== undefined && self.hourElement.select();
        }, 451);

        if (self.config.closeOnSelect) {
          var single = self.config.mode === "single" && !self.config.enableTime;
          var range = self.config.mode === "range" && self.selectedDates.length === 2 && !self.config.enableTime;

          if (single || range) {
            focusAndClose();
          }
        }

        triggerChange();
      }

      var CALLBACKS = {
        locale: [setupLocale, updateWeekdays],
        showMonths: [buildMonths, setCalendarWidth, buildWeekdays]
      };

      function set(option, value) {
        if (option !== null && typeof option === "object") Object.assign(self.config, option);else {
          self.config[option] = value;
          if (CALLBACKS[option] !== undefined) CALLBACKS[option].forEach(function (x) {
            return x();
          });else if (HOOKS.indexOf(option) > -1) self.config[option] = arrayify(value);
        }
        self.redraw();
        jumpToDate();
        updateValue(false);
      }

      function setSelectedDate(inputDate, format) {
        var dates = [];
        if (inputDate instanceof Array) dates = inputDate.map(function (d) {
          return self.parseDate(d, format);
        });else if (inputDate instanceof Date || typeof inputDate === "number") dates = [self.parseDate(inputDate, format)];else if (typeof inputDate === "string") {
          switch (self.config.mode) {
            case "single":
            case "time":
              dates = [self.parseDate(inputDate, format)];
              break;

            case "multiple":
              dates = inputDate.split(self.config.conjunction).map(function (date) {
                return self.parseDate(date, format);
              });
              break;

            case "range":
              dates = inputDate.split(self.l10n.rangeSeparator).map(function (date) {
                return self.parseDate(date, format);
              });
              break;

            default:
              break;
          }
        } else self.config.errorHandler(new Error("Invalid date supplied: " + JSON.stringify(inputDate)));
        self.selectedDates = dates.filter(function (d) {
          return d instanceof Date && isEnabled(d, false);
        });
        if (self.config.mode === "range") self.selectedDates.sort(function (a, b) {
          return a.getTime() - b.getTime();
        });
      }

      function setDate(date, triggerChange, format) {
        if (triggerChange === void 0) {
          triggerChange = false;
        }

        if (format === void 0) {
          format = self.config.dateFormat;
        }

        if (date !== 0 && !date || date instanceof Array && date.length === 0) return self.clear(triggerChange);
        setSelectedDate(date, format);
        self.showTimeInput = self.selectedDates.length > 0;
        self.latestSelectedDateObj = self.selectedDates[0];
        self.redraw();
        jumpToDate();
        setHoursFromDate();
        updateValue(triggerChange);
        if (triggerChange) triggerEvent("onChange");
      }

      function parseDateRules(arr) {
        return arr.slice().map(function (rule) {
          if (typeof rule === "string" || typeof rule === "number" || rule instanceof Date) {
            return self.parseDate(rule, undefined, true);
          } else if (rule && typeof rule === "object" && rule.from && rule.to) return {
            from: self.parseDate(rule.from, undefined),
            to: self.parseDate(rule.to, undefined)
          };

          return rule;
        }).filter(function (x) {
          return x;
        });
      }

      function setupDates() {
        self.selectedDates = [];
        self.now = self.parseDate(self.config.now) || new Date();
        var preloadedDate = self.config.defaultDate || ((self.input.nodeName === "INPUT" || self.input.nodeName === "TEXTAREA") && self.input.placeholder && self.input.value === self.input.placeholder ? null : self.input.value);
        if (preloadedDate) setSelectedDate(preloadedDate, self.config.dateFormat);
        var initialDate = self.selectedDates.length > 0 ? self.selectedDates[0] : self.config.minDate && self.config.minDate.getTime() > self.now.getTime() ? self.config.minDate : self.config.maxDate && self.config.maxDate.getTime() < self.now.getTime() ? self.config.maxDate : self.now;
        self.currentYear = initialDate.getFullYear();
        self.currentMonth = initialDate.getMonth();
        if (self.selectedDates.length > 0) self.latestSelectedDateObj = self.selectedDates[0];
        if (self.config.minTime !== undefined) self.config.minTime = self.parseDate(self.config.minTime, "H:i");
        if (self.config.maxTime !== undefined) self.config.maxTime = self.parseDate(self.config.maxTime, "H:i");
        self.minDateHasTime = !!self.config.minDate && (self.config.minDate.getHours() > 0 || self.config.minDate.getMinutes() > 0 || self.config.minDate.getSeconds() > 0);
        self.maxDateHasTime = !!self.config.maxDate && (self.config.maxDate.getHours() > 0 || self.config.maxDate.getMinutes() > 0 || self.config.maxDate.getSeconds() > 0);
        Object.defineProperty(self, "showTimeInput", {
          get: function get() {
            return self._showTimeInput;
          },
          set: function set(bool) {
            self._showTimeInput = bool;
            if (self.calendarContainer) toggleClass(self.calendarContainer, "showTimeInput", bool);
            self.isOpen && positionCalendar();
          }
        });
      }

      function setupInputs() {
        self.input = self.config.wrap ? element.querySelector("[data-input]") : element;

        if (!self.input) {
          self.config.errorHandler(new Error("Invalid input element specified"));
          return;
        }

        self.input._type = self.input.type;
        self.input.type = "text";
        self.input.classList.add("flatpickr-input");
        self._input = self.input;

        if (self.config.altInput) {
          self.altInput = createElement(self.input.nodeName, self.input.className + " " + self.config.altInputClass);
          self._input = self.altInput;
          self.altInput.placeholder = self.input.placeholder;
          self.altInput.disabled = self.input.disabled;
          self.altInput.required = self.input.required;
          self.altInput.tabIndex = self.input.tabIndex;
          self.altInput.type = "text";
          self.input.setAttribute("type", "hidden");
          if (!self.config.static && self.input.parentNode) self.input.parentNode.insertBefore(self.altInput, self.input.nextSibling);
        }

        if (!self.config.allowInput) self._input.setAttribute("readonly", "readonly");
        self._positionElement = self.config.positionElement || self._input;
      }

      function setupMobile() {
        var inputType = self.config.enableTime ? self.config.noCalendar ? "time" : "datetime-local" : "date";
        self.mobileInput = createElement("input", self.input.className + " flatpickr-mobile");
        self.mobileInput.step = self.input.getAttribute("step") || "any";
        self.mobileInput.tabIndex = 1;
        self.mobileInput.type = inputType;
        self.mobileInput.disabled = self.input.disabled;
        self.mobileInput.required = self.input.required;
        self.mobileInput.placeholder = self.input.placeholder;
        self.mobileFormatStr = inputType === "datetime-local" ? "Y-m-d\\TH:i:S" : inputType === "date" ? "Y-m-d" : "H:i:S";

        if (self.selectedDates.length > 0) {
          self.mobileInput.defaultValue = self.mobileInput.value = self.formatDate(self.selectedDates[0], self.mobileFormatStr);
        }

        if (self.config.minDate) self.mobileInput.min = self.formatDate(self.config.minDate, "Y-m-d");
        if (self.config.maxDate) self.mobileInput.max = self.formatDate(self.config.maxDate, "Y-m-d");
        self.input.type = "hidden";
        if (self.altInput !== undefined) self.altInput.type = "hidden";

        try {
          if (self.input.parentNode) self.input.parentNode.insertBefore(self.mobileInput, self.input.nextSibling);
        } catch (_a) {}

        bind(self.mobileInput, "change", function (e) {
          self.setDate(e.target.value, false, self.mobileFormatStr);
          triggerEvent("onChange");
          triggerEvent("onClose");
        });
      }

      function toggle(e) {
        if (self.isOpen === true) return self.close();
        self.open(e);
      }

      function triggerEvent(event, data) {
        if (self.config === undefined) return;
        var hooks = self.config[event];

        if (hooks !== undefined && hooks.length > 0) {
          for (var i = 0; hooks[i] && i < hooks.length; i++) {
            hooks[i](self.selectedDates, self.input.value, self, data);
          }
        }

        if (event === "onChange") {
          self.input.dispatchEvent(createEvent("change"));
          self.input.dispatchEvent(createEvent("input"));
        }
      }

      function createEvent(name) {
        var e = document.createEvent("Event");
        e.initEvent(name, true, true);
        return e;
      }

      function isDateSelected(date) {
        for (var i = 0; i < self.selectedDates.length; i++) {
          if (compareDates(self.selectedDates[i], date) === 0) return "" + i;
        }

        return false;
      }

      function isDateInRange(date) {
        if (self.config.mode !== "range" || self.selectedDates.length < 2) return false;
        return compareDates(date, self.selectedDates[0]) >= 0 && compareDates(date, self.selectedDates[1]) <= 0;
      }

      function updateNavigationCurrentMonth() {
        if (self.config.noCalendar || self.isMobile || !self.monthNav) return;
        self.yearElements.forEach(function (yearElement, i) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i);
          self.monthElements[i].textContent = monthToStr(d.getMonth(), self.config.shorthandCurrentMonth, self.l10n) + " ";
          yearElement.value = d.getFullYear().toString();
        });
        self._hidePrevMonthArrow = self.config.minDate !== undefined && (self.currentYear === self.config.minDate.getFullYear() ? self.currentMonth <= self.config.minDate.getMonth() : self.currentYear < self.config.minDate.getFullYear());
        self._hideNextMonthArrow = self.config.maxDate !== undefined && (self.currentYear === self.config.maxDate.getFullYear() ? self.currentMonth + 1 > self.config.maxDate.getMonth() : self.currentYear > self.config.maxDate.getFullYear());
      }

      function getDateStr(format) {
        return self.selectedDates.map(function (dObj) {
          return self.formatDate(dObj, format);
        }).filter(function (d, i, arr) {
          return self.config.mode !== "range" || self.config.enableTime || arr.indexOf(d) === i;
        }).join(self.config.mode !== "range" ? self.config.conjunction : self.l10n.rangeSeparator);
      }

      function updateValue(triggerChange) {
        if (triggerChange === void 0) {
          triggerChange = true;
        }

        if (self.selectedDates.length === 0) return self.clear(triggerChange);

        if (self.mobileInput !== undefined && self.mobileFormatStr) {
          self.mobileInput.value = self.latestSelectedDateObj !== undefined ? self.formatDate(self.latestSelectedDateObj, self.mobileFormatStr) : "";
        }

        self.input.value = getDateStr(self.config.dateFormat);

        if (self.altInput !== undefined) {
          self.altInput.value = getDateStr(self.config.altFormat);
        }

        if (triggerChange !== false) triggerEvent("onValueUpdate");
      }

      function onMonthNavClick(e) {
        e.preventDefault();
        var isPrevMonth = self.prevMonthNav.contains(e.target);
        var isNextMonth = self.nextMonthNav.contains(e.target);

        if (isPrevMonth || isNextMonth) {
          changeMonth(isPrevMonth ? -1 : 1);
        } else if (self.yearElements.indexOf(e.target) >= 0) {
          e.target.select();
        } else if (e.target.classList.contains("arrowUp")) {
          self.changeYear(self.currentYear + 1);
        } else if (e.target.classList.contains("arrowDown")) {
          self.changeYear(self.currentYear - 1);
        }
      }

      function timeWrapper(e) {
        e.preventDefault();
        var isKeyDown = e.type === "keydown",
            input = e.target;

        if (self.amPM !== undefined && e.target === self.amPM) {
          self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
        }

        var min = parseFloat(input.getAttribute("data-min")),
            max = parseFloat(input.getAttribute("data-max")),
            step = parseFloat(input.getAttribute("data-step")),
            curValue = parseInt(input.value, 10),
            delta = e.delta || (isKeyDown ? e.which === 38 ? 1 : -1 : 0);
        var newValue = curValue + step * delta;

        if (typeof input.value !== "undefined" && input.value.length === 2) {
          var isHourElem = input === self.hourElement,
              isMinuteElem = input === self.minuteElement;

          if (newValue < min) {
            newValue = max + newValue + int(!isHourElem) + (int(isHourElem) && int(!self.amPM));
            if (isMinuteElem) incrementNumInput(undefined, -1, self.hourElement);
          } else if (newValue > max) {
            newValue = input === self.hourElement ? newValue - max - int(!self.amPM) : min;
            if (isMinuteElem) incrementNumInput(undefined, 1, self.hourElement);
          }

          if (self.amPM && isHourElem && (step === 1 ? newValue + curValue === 23 : Math.abs(newValue - curValue) > step)) {
            self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
          }

          input.value = pad(newValue);
        }
      }

      init();
      return self;
    }

    function _flatpickr(nodeList, config) {
      var nodes = Array.prototype.slice.call(nodeList);
      var instances = [];

      for (var i = 0; i < nodes.length; i++) {
        var node = nodes[i];

        try {
          if (node.getAttribute("data-fp-omit") !== null) continue;

          if (node._flatpickr !== undefined) {
            node._flatpickr.destroy();

            node._flatpickr = undefined;
          }

          node._flatpickr = FlatpickrInstance(node, config || {});
          instances.push(node._flatpickr);
        } catch (e) {
          console.error(e);
        }
      }

      return instances.length === 1 ? instances[0] : instances;
    }

    if (typeof HTMLElement !== "undefined") {
      HTMLCollection.prototype.flatpickr = NodeList.prototype.flatpickr = function (config) {
        return _flatpickr(this, config);
      };

      HTMLElement.prototype.flatpickr = function (config) {
        return _flatpickr([this], config);
      };
    }

    var flatpickr = function flatpickr(selector, config) {
      if (selector instanceof NodeList) return _flatpickr(selector, config);else if (typeof selector === "string") return _flatpickr(window.document.querySelectorAll(selector), config);
      return _flatpickr([selector], config);
    };

    flatpickr.defaultConfig = defaults;
    flatpickr.l10ns = {
      en: Object.assign({}, english),
      default: Object.assign({}, english)
    };

    flatpickr.localize = function (l10n) {
      flatpickr.l10ns.default = Object.assign({}, flatpickr.l10ns.default, l10n);
    };

    flatpickr.setDefaults = function (config) {
      flatpickr.defaultConfig = Object.assign({}, flatpickr.defaultConfig, config);
    };

    flatpickr.parseDate = createDateParser({});
    flatpickr.formatDate = createDateFormatter({});
    flatpickr.compareDates = compareDates;

    if (typeof jQuery !== "undefined") {
      jQuery.fn.flatpickr = function (config) {
        return _flatpickr(this, config);
      };
    }

    Date.prototype.fp_incr = function (days) {
      return new Date(this.getFullYear(), this.getMonth(), this.getDate() + (typeof days === "string" ? parseInt(days, 10) : days));
    };

    if (typeof window !== "undefined") {
      window.flatpickr = flatpickr;
    }

    return flatpickr;

})));
// ========== end flatpickr
