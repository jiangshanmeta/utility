## vframe

* src iframe的src
* ratio iframe的长宽比，默认为1

解决iframe的尺寸(高度)问题

```html
<vframe src="https://v.qq.com/iframe/player.html?vid=a0511nb4te1&tiny=0&auto=0" :ratio="0.778" ></vframe>
```

## vtitle

```javascript
Vue.component('v-title',vtitle);
```

```html
<v-title>客户{{username}}</v-title>
```

可以在页面内控制title