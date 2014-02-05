var LOCATION=LOCATION||{}
LOCATION.app=new function(){var API_KEY='d48e237df8c71d6da9dbe680d3decc978aa98c4b4365277b0cc70a40b72897f8',API_URL='http://api.ipinfodb.com/v3/ip-country/?format=json&key=';var country=null,priceMatrix_s=[29.99,49.99,39.99,49.95],priceMatrix_sw=[19.99,29.99,29.99,29.95],priceMatrix_m=[39.99,69.99,49.99,79.95],priceMatrix_l=[99.99,99.99,99.99,149.00],world_list=['AFGHANISTAN','ALBANIA','ALGERIA','ANDORRA','ANGOLA','ANTIGUA & DEPS','ARGENTINA','ARMENIA','AUSTRALIA','AUSTRIA','AZERBAIJAN','BAHAMAS','BAHRAIN','BANGLADESH','BARBADOS','BELARUS','BELGIUM','BELIZE','BENIN','BHUTAN','BOLIVIA','BOSNIA HERZEGOVINA','BOTSWANA','BRAZIL','BRUNEI','BULGARIA','BURKINA','BURUNDI','CAMBODIA','CAMEROON','CAPE VERDE','CENTRAL AFRICAN REP','CHAD','CHILE','CHINA','COLOMBIA','COMOROS','CONGO','CONGO {DEMOCRATIC REP}','COSTA RICA','CROATIA','CUBA','CYPRUS','CZECH REPUBLIC','DENMARK','DJIBOUTI','DOMINICA','DOMINICAN REPUBLIC','EAST TIMOR','ECUADOR','EGYPT','EL SALVADOR','EQUATORIAL GUINEA','ERITREA','ESTONIA','ETHIOPIA','FIJI','FINLAND','FRANCE','GABON','GAMBIA','GEORGIA','GERMANY','GHANA','GREECE','GRENADA','GUATEMALA','GUINEAV','GUINEA-BISSAU','GUYANA','HAITI','HONDURAS','HUNGARY','ICELAND','INDIA','INDONESIA','IRAN','IRAQ','IRELAND {REPUBLIC}','ISRAEL','ITALY','IVORY COAST','JAMAICA','JAPAN','JORDAN','KAZAKHSTAN','KENYA','KIRIBATI','KOREA NORTH','KOREA SOUTH','KOSOVO','KUWAIT','KYRGYZSTAN','LAOS','LATVIA','LEBANON','LESOTHO','LIBERIA','LIBYA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACEDONIA','MADAGASCAR','MALAWI','MALAYSIA','MALDIVES','MALI','MALTA','MARSHALL ISLANDS','MAURITANIA','MAURITIUS','MEXICO','MICRONESIA','MOLDOVA','MONACO','MONGOLIA','MONTENEGRO','MOROCCO','MOZAMBIQUE','MYANMAR, {BURMA}','NAMIBIA','NAURU','NEPAL','NETHERLANDS','NEW ZEALAND','NICARAGUA','NIGER','NIGERIA','NORWAY','OMAN','PAKISTAN','PALAU','PANAMA','PAPUA NEW GUINEA','PARAGUAY','PERU','PHILIPPINES','POLAND','PORTUGAL','QATAR','ROMANIA','RUSSIAN FEDERATION','RWANDA','ST KITTS & NEVIS','ST LUCIA','SAINT VINCENT & THE GRENADINES','SAMOA','SAN MARINO','SAO TOME & PRINCIPE','SAUDI ARABIA','SENEGAL','SERBIA','SEYCHELLES','SIERRA LEONE','SINGAPORE','SLOVAKIA','SLOVENIA','SOLOMON ISLANDS','SOMALIA','SOUTH AFRICA','SOUTH SUDAN','SPAIN','SRI LANKA','SUDAN','SURINAME','SWAZILAND','SWEDEN','SWITZERLAND','SYRIA','TAIWAN','TAJIKISTAN','TANZANIA','THAILAND','TOGO','TONGA','TRINIDAD & TOBAGO','TUNISIA','TURKEY','TURKMENISTAN','TUVALU','UGANDA','UKRAINE','UNITED ARAB EMIRATES','URUGUAY','UZBEKISTAN','VANUATU','VATICAN CITY','VENEZUELA','VIETNAM','YEMEN','ZAMBIA','ZIMBABWE'],europe_list=['ALBANIA','ANDORRA','ARMENIA','AUSTRIA','AZERBAIJAN','BELARUS','BELGIUM','BOSNIA & HERZEGOVINA','BULGARIA','CROATIA','CYPRUS','CZECH','REPUBLIC','DENMARK','ESTONIA','FINLAND','FRANCE','GEORGIA','GERMANY','GREECE','HUNGARY','ICELAND','IRELAND','ITALY','KOSOVO','LATVIA','LIECHTENSTEIN','LITHUANIA','LUXEMBOURG','MACEDONIA','MALTA','MOLDOVA','MONACO','MONTENEGRO','THE NETHERLANDS','NORWAY','POLAND','PORTUGAL','ROMANIA','RUSSIA','SAN MARINO','SERBIA','SLOVAKIA','SLOVENIA','SPAIN','SWEDEN','SWITZERLAND','TURKEY','UKRAINE','UNITED KINGDOM','VATICAN CITY'];this.init=function(){getLocation(function(data){country=data.countryName;for(var i=0,n=world_list.length;i<n;i++){if(data.countryName==world_list[i]){jQuery('.price_sw').html('&#36;'+priceMatrix_sw[1]);jQuery('.price_s').html('&#36;'+priceMatrix_s[1]);jQuery('.price_m').html('&#36;'+priceMatrix_m[1]);jQuery('.price_l').html('&#36;'+priceMatrix_l[1]);console.log(data.countryName);}}
for(var i=0,n=europe_list.length;i<n;i++){if(data.countryName==europe_list[i]){jQuery('.price_sw').html('&#36;'+priceMatrix_sw[2]);jQuery('.price_s').html('&#36;'+priceMatrix_s[2]);jQuery('.price_m').html('&#36;'+priceMatrix_m[2]);jQuery('.price_l').html('&#36;'+priceMatrix_l[2]);console.log(data.countryName);}}
if(data.countryName=='UNITED KINGDOM'){jQuery('.price_sw').html('&pound;'+priceMatrix_sw[0]);jQuery('.price_s').html('&pound;'+priceMatrix_s[0]);jQuery('.price_m').html('&pound;'+priceMatrix_m[0]);jQuery('.price_l').html('&pound;'+priceMatrix_l[0]);console.log(data.countryName);}
if(data.countryName=='AUSTRALIA'){jQuery('.price_sw').html('A&#36;'+priceMatrix_sw[3]);jQuery('.price_s').html('A&#36;'+priceMatrix_s[3]);jQuery('.price_m').html('A&#36;'+priceMatrix_m[3]);jQuery('.price_l').html('A&#36;'+priceMatrix_l[3]);console.log(data.countryName);}});}
function getLocation(callback){iplookup=new Json();iplookup.url=API_URL+API_KEY;iplookup.get(function(data){callback(data);});}
jQuery(window).load(function(){});function Json(){this.url='';this.get=function(callback)
{jQuery.getJSON(this.url+'&callback=?',function(data){callback(data);});}}
function rand(min,max){return Math.random()*(max-min)+min;}}