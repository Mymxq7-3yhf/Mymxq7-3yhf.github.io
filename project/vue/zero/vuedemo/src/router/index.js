import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

import Message from '../components/Message'
import Add from '../components/Add'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/Message',
      name: 'Message',
      component: Message
    },
    {
      path: '/Add',
      name: 'Add',
      component: Add
    }
  ]
})
