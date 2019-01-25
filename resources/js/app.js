
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'
import VueQuillEditor from 'vue-quill-editor'
import VModal from 'vue-js-modal'
import VueMoment from 'vue-moment'
import Notifications from 'vue-notification'

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

window.Vue = require('vue');
Vue.use(VueQuillEditor)
Vue.use(VModal, { dynamic: true, injectModalsContainer: true, dialog: true });
Vue.use(VueMoment);
Vue.use(Notifications);

/**
 * Additional component
 */
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('spinner', require('./components/includes/Spinner.vue'));
Vue.component('text-loading', require('./components/includes/TextLoading.vue'));
Vue.component('paragraph-loading', require('./components/includes/ParagraphLoading.vue'));
Vue.component('spinner-grey', require('./components/includes/SpinnerGrey.vue'));
Vue.component('title-section', require('./components/includes/TitleSection.vue'));
Vue.component('card-horizontal-loading', require('./components/includes/CardHorizontal.vue'));

/**
 * Backend component
 * Please register all backend component here
 */
Vue.component('dashboard-info', require('./components/backend/dashboard/DashboardInfo.vue'));
Vue.component('school-contact', require('./components/backend/dashboard/SchoolContact.vue'));
Vue.component('school-info', require('./components/backend/dashboard/SchoolInfo.vue'));
Vue.component('profile', require('./components/backend/profile/SchoolProfile.vue'));
Vue.component('teacher', require('./components/backend/teacher/TeacherList.vue'));
Vue.component('program', require('./components/backend/program/ProgramList.vue'));
Vue.component('student', require('./components/backend/student/StudentList.vue'));
Vue.component('event', require('./components/backend/event/EventList.vue'));
Vue.component('create-event', require('./components/backend/event/CreateEvent.vue'));
Vue.component('update-event', require('./components/backend/event/UpdateEvent.vue'));
Vue.component('show-event', require('./components/backend/event/DetailEvent.vue'));
Vue.component('achievement', require('./components/backend/achievement/AchievementList.vue'));
Vue.component('create-achievement', require('./components/backend/achievement/CreateAchievement.vue'));
Vue.component('update-achievement', require('./components/backend/achievement/UpdateAchievement.vue'));
Vue.component('account', require('./components/backend/account/AccountList.vue'));
Vue.component('category', require('./components/backend/category/CategoryList.vue'));
Vue.component('albums-list', require('./components/backend/gallery/AlbumList.vue'));
Vue.component('list-gallery', require('./components/backend/gallery/GalleryList.vue'));

/**
 * Frontend component
 * Please register all frontend component here
 */
Vue.component('homepage-program', require('./components/frontend/homepage/HomeProgram.vue'));
Vue.component('homepage-achievement', require('./components/frontend/homepage/HomeAchievement.vue'));
Vue.component('homepage-intro', require('./components/frontend/homepage/HomeIntro.vue'));
Vue.component('homepage-event', require('./components/frontend/homepage/HomeEvent.vue'));
Vue.component('homepage-header', require('./components/frontend/homepage/HomeHeader.vue'));
Vue.component('header-info', require('./components/frontend/layouts/header.vue'));
Vue.component('footer-info', require('./components/frontend/layouts/footerInfo.vue'));
Vue.component('school-profile', require('./components/frontend/profile/schoolProfile.vue'));





// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
