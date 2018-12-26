<template>
    <div class="rectangle">
        <div :style="{paddingBottom:`${ratio*100}%`}"></div>
        <div class="rectangle-inner">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default{
    props:{
        // 高宽比
        ratio:{
            type:Number,
            required:true,
        },
    },
}
</script>

<style scoped>
.rectangle{
    position:relative;
}
.rectangle-inner{
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    width:100%;
    height:100%;
}
</style>