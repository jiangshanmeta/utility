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

## vframe

props：

* src iframe的src
* ratio iframe的长宽比

解决iframe的尺寸(高度)问题

```html
<vframe src="https://v.qq.com/iframe/player.html?vid=a0511nb4te1&tiny=0&auto=0" :ratio="0.778" ></vframe>
```

## grayimg

用灰度比例表示进度的图

props:

* ratio 小数，灰度比例
* src 图片链接
* grayclass 实现灰度的CSS类名
* dir 方向，可以从 btt ttb ltr rtl 选择

```html
<grayimg src="/misc/js/08.jpg" v-bind:ratio="ratio" dir='rtl' grayclass="gray1"></grayimg>
```

## vaudio

对audio封装的，提供开始/停止播放功能，主要用于h5页面

props：

* playimgsrc 播放时展示的图片，必填
* pauseimgsrc 停止时展示的图片，必填
* src audio的src，必填
* playimgclass 播放时图片的类，选填，默认为空
* pauseimgclass 停止时图片的类，选填，默认为空
* autoplay 是否自动播放，如不需要自动播放请勿添加此属性
* loop 是否循环播放，默认循环播放


方法：

* play 播放音频，但用户停止播放后无法通过该方法播放音频
* pause 停止播放

```html
<vaudio 
	playimgsrc="/misc/imgs/music_close.png" 
	pauseimgsrc="/misc/imgs/music_close_open.png"
	src="/misc/audio/bgm.mp3"
	playimgclass="animated rotate infinite"
	pauseimgclass=""
    autoplay="autoplay"
></vaudio>
```

## vue-config

为Vue添加一个选项config，config中的字段会被代理到vue实例上，但这些字段不是响应式的

## b-modal

模态框，依赖于bootstrap的样式

方法：

* show 显示模态框
* hide 关闭模态框

props:

* type 用于控制模态框大小的类名，在bootstrap中提供了 modal-sm 和 modal-lg

slots:

* header 用于modal-header的slot
* 默认slot 用于modal-body的slot
* footer 用于modal-footer的slot

事件：

* show
* shown
* hide
* hidden

## b-alert

警告框，依赖于bootstrap的样式

props：

* type 警告框类型

事件：

* show
* shown
* hide
* hidden