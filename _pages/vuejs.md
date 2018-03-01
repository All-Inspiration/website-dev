---
ID: 6
post_title: News
author: frugs
post_excerpt: ""
layout: page
permalink: https://dev.allinspirationpro.com/vuejs/
published: true
post_date: 2018-02-28 18:30:19
---
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<div id="app">{{ message }}</div>
<script>
const AllinPost = Vue.extend({
  template: 'A custom component!'
});

Vue.component('allin-post', AllinPost);

const app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!'
  }
});
</script>