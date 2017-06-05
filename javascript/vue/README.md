这里存放我写的Vue相关组件、插件等

## mapimg

这个是针对图片的map功能的拓展：

* 增加了coords属性对百分比的支持
* 事件作用域限定在父组件中

```html
<mapimg 
	:map="[
	  {shape:'rect',coords:'0,0,50%,50%',target:'_blank',href:'http://github.com/jiangshanmeta'},
	  {shape:'circle',coords:'50%,50%,20%',on:{click:'naive'}},
	  {shape:'poly',coords:'0,50%,50%,0,100%,50%,50%,100%',on:{click:'gotoPage(1,a)'}}
	]"

	src="https://avatars0.githubusercontent.com/u/13798212">
</mapimg>
```

## posimg

用于确定某点在图片位置的百分比，鼠标点击确定该点

```html
<posimg src="/misc/js/08.jpg"></posimg>
```