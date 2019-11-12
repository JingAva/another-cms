import Dashboard from '../pages/dashboard/dashboard.vue';
import Users from '../pages/users/users.vue';
import Reports from '../pages/reports/reports.vue';
import Settings from '../pages/settings/settings.vue';
import Pages from '../pages/pages/index.vue';

export const adminRoutes = [
  {path: '', name:'dashboard', component: Dashboard},
  {path: '/users', name:'users', component: Users},
  {path: '/reports', name:'reports', component: Reports},
  {path: '/settings', name:'settings', component: Settings},
  {path: '/pages', name:'pages', component: Pages},
];