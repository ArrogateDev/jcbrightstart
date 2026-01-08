<?php

namespace Database\Seeders;

use App\Models\Base;
use App\Models\Manage\Authority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class AuthoritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $authorities[] = [
            'name' => '家长及课程管理',
            'alias' => 'MainMenuManage',
            'sort' => 0,
            'type' => Authority::MENU_TYPE,
            'pid' => 0,
            'children' => [
                [
                    'name' => '仪表板',
                    'alias' => 'DashboardList',
                    'icon' => 'isax isax-grid-35',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => []
                ],
                [
                    'name' => '课程管理',
                    'alias' => 'CourseList',
                    'icon' => 'isax isax-teacher5',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加课程',
                            'alias' => 'CourseAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑课程',
                            'alias' => 'CourseEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除课程',
                            'alias' => 'CourseDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '家长管理',
                    'alias' => 'ParentList',
                    'icon' => 'fa-solid fa-person-breastfeeding',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '编辑家长',
                            'alias' => 'ParentEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除家长',
                            'alias' => 'ParentDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '测验管理',
                    'alias' => 'QuizList',
                    'icon' => 'isax isax-award5',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加测验',
                            'alias' => 'QuizAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑测验',
                            'alias' => 'QuizEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除测验',
                            'alias' => 'QuizDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '测验结果',
                            'alias' => 'QuizResultsList',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [

                    'name' => '证书管理',
                    'alias' => 'CertificateList',
                    'icon' => 'isax isax-note-215',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加证书',
                            'alias' => 'CertificateAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑证书',
                            'alias' => 'CertificateEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除证书',
                            'alias' => 'CertificateDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ]
            ]
        ];

        $authorities[] = [
            'name' => '网页管理',
            'alias' => 'WebpageManage',
            'sort' => 0,
            'type' => Authority::MENU_TYPE,
            'pid' => 0,
            'children' => [
                [
                    'name' => '最新消息',
                    'alias' => 'NewsList',
                    'icon' => 'isax isax-messages-35',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加消息',
                            'alias' => 'NewsAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑消息',
                            'alias' => 'NewsEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除消息',
                            'alias' => 'NewsDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '最新消息分类',
                    'alias' => 'NewsCategoryList',
                    'icon' => 'isax isax-ticket5',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加分类',
                            'alias' => 'NewsCategoryAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑分类',
                            'alias' => 'NewsCategoryEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除分类',
                            'alias' => 'NewsCategoryDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '专业学习社群',
                    'alias' => 'ResourceList',
                    'icon' => 'isax isax-save-2',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加资源',
                            'alias' => 'ResourceAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑资源',
                            'alias' => 'ResourceEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除资源',
                            'alias' => 'ResourceDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '专业学习社群领域',
                    'alias' => 'ResourceCategoryList',
                    'icon' => 'isax isax-save-add',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加领域',
                            'alias' => 'ResourceCategoryAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑领域',
                            'alias' => 'ResourceCategoryEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除领域',
                            'alias' => 'ResourceCategoryDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ]
            ]
        ];

        $authorities[] = [
            'name' => '权限管理',
            'alias' => 'AuthorityManage',
            'sort' => 0,
            'type' => Authority::MENU_TYPE,
            'pid' => 0,
            'children' => [
                [
                    'name' => '角色管理',
                    'alias' => 'RoleList',
                    'icon' => 'fa-solid fa-sitemap',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加角色',
                            'alias' => 'RoleAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑角色',
                            'alias' => 'RoleEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除角色',
                            'alias' => 'RoleDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ],
                [
                    'name' => '管理员管理',
                    'alias' => 'AdminList',
                    'icon' => 'fa-solid fa-user-tie',
                    'sort' => 0,
                    'type' => Authority::GPS_TYPE,
                    'children' => [
                        [
                            'name' => '添加管理员',
                            'alias' => 'AdminAdd',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '编辑配置',
                            'alias' => 'AdminEdit',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ],
                        [
                            'name' => '删除管理员',
                            'alias' => 'AdminDelete',
                            'sort' => 0,
                            'type' => Authority::BUTTON_TYPE,
                            'children' => []
                        ]
                    ]
                ]
            ]
        ];

        $total = count($authorities);
        foreach ($authorities as $index => $level0_item) {
            if (!($level0 = Authority::query()->where('alias', $level0_item['alias'])->first())) {
                $level0 = new Authority();
                $level0->name = $level0_item['name'];
                $level0->alias = $level0_item['alias'];
                $level0->icon = $level0_item['icon'] ?? '';
                $level0->type = $level0_item['type'];
                $level0->pid = $level0_item['pid'];
                $level0->sort = ($total * 1000) - ($index * 1000);
                $level0->save();
            }
            foreach ($level0_item['children'] ?? [] as $l1 => $level1_item) {
                if (!($level1 = Authority::query()->where('alias', $level1_item['alias'])->first())) {
                    $level1 = new Authority();
                    $level1->name = $level1_item['name'];
                    $level1->alias = $level1_item['alias'];
                    $level1->icon = $level1_item['icon'] ?? '';
                    $level1->sort = $level0->sort - (($l1 + 1) * 100);
                    $level1->type = $level1_item['type'];
                    $level1->pid = $level0->id;
                    $level1->save();
                }
                foreach ($level1_item['children'] ?? [] as $l2 => $level02_item) {
                    if (!($level2 = Authority::query()->where('alias', $level02_item['alias'])->first())) {
                        $level2 = new Authority();
                        $level2->name = $level02_item['name'];
                        $level2->alias = $level02_item['alias'];
                        $level2->icon = $level02_item['icon'] ?? '';
                        $level2->sort = $level1->sort - (($l2 + 1) * 10);
                        $level2->type = $level02_item['type'];
                        $level2->pid = $level1->id;
                        $level2->save();
                    }
                    foreach ($level02_item['children'] ?? [] as $l3 => $level3_item) {
                        if (!Authority::query()->where('alias', $level3_item['alias'])->exists()) {
                            $level3 = new Authority();
                            $level3->name = $level3_item['name'];
                            $level3->alias = $level3_item['alias'];
                            $level3->icon = $level3_item['icon'] ?? '';
                            $level3->sort = $level2->sort - $l3 + 1;
                            $level3->type = $level3_item['type'];
                            $level3->pid = $level2->id;
                            $level3->save();
                        }
                    }
                }
            }
        }

        Cache::tags(['MENUS'])->flush();
    }
}
