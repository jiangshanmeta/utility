## Moment

这个library是用来封装常用的日期处理功能

#### $moment->get_curTS()

	返回当前时间戳

#### $moment->strtotime($str)

	* $str 要处理的字符串

	根据```$str```返回时间戳

#### $moment->set_timezone($str)

	* $str 设定时区字符串

	设定时区

#### $moment->get_prev_month_str($ts,$fmt)
	
	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m```

	根据```$ts```返回上个月的日期字符串

#### $moment->get_cur_month_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m```

	根据```$ts```返回该月的日期字符串

#### $moment->get_next_month_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m```

	根据```$ts```返回下个月的日期字符串


#### $moment->get_prev_week_str($ts,$fmt)
	
	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回上个周的日期字符串

#### $moment->get_cur_week_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回该周的日期字符串

#### $moment->get_next_week_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回下个周的日期字符串

#### $moment->get_prev_day_str($ts,$fmt)
	
	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回上一天的日期字符串

#### $moment->get_cur_day_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回该日的日期字符串

#### $moment->get_next_day_str($ts,$fmt)

	* $ts 时间戳或者日期字符串，默认为当前时间
	* $fmt 规格化字符串格式，默认为```Y-m-d```

	根据```$ts```返回下一天的日期字符串


#### $moment->get_month_beginTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该月开始的时间戳

#### $moment->get_month_endTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该月结束的时间戳

#### $moment->get_week_beginTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该周开始的时间戳

#### $moment->get_week_endTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该周结束的时间戳

#### $moment->get_day_beginTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该日开始的时间戳

#### $moment->get_day_endTS($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```获取该日结束的时间戳

#### $moment->get_days_in_month($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```返回该月天数

#### $moment->get_which_day_of_year($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```返回在当年第几天，从1开始计算

#### $moment->get_which_day_of_month($ts)
	
	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```返回在当月第几天，从1开始计算

#### $moment->get_which_day_of_week($ts)

	* $ts 时间戳或者日期字符串，默认为当前时间

	根据```$ts```返回在一周的第几天，从周日开始计算(周日=>0，周一=>1)。

