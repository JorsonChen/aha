<?php

/*
 *首页导航路由
 */
Breadcrumbs::register("admin.index", function ($breadcrumbs) {
    $breadcrumbs->push("首页", route("admin.index"));
});

/*
 *用户管理导航路由
 */
Breadcrumbs::register("admin.user.manage", function ($breadcrumbs){
    $breadcrumbs->push("用户管理", route("admin.user.manage"));
});

    //用户权限列表
    Breadcrumbs::register("admin.permission.index", function ($breadcrumbs) {
        $breadcrumbs->parent("admin.user.manage");
        $breadcrumbs->push("权限列表", route("admin.permission.index"));
    });
        Breadcrumbs::register("admin.permission.create", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.permission.index");
            $breadcrumbs->push("添加权限", route("admin.permission.create"));
        });
        Breadcrumbs::register("admin.permission.edit", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.permission.index");
            $breadcrumbs->push("修改权限", route("admin.permission.edit"));
        });
        Breadcrumbs::register("admin.permission.destroy ", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.permission.index");
            $breadcrumbs->push("删除权限", route("admin.permission.destroy "));
        });

    //用户列表    
    Breadcrumbs::register("admin.user.index", function ($breadcrumbs) {
        $breadcrumbs->parent("admin.user.manage");
        $breadcrumbs->push("用户列表", route("admin.user.index"));
    });
        Breadcrumbs::register("admin.user.create", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.user.index");
            $breadcrumbs->push("添加用户", route("admin.user.create"));
        });
        Breadcrumbs::register("admin.user.edit", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.user.index");
            $breadcrumbs->push("编辑用户", route("admin.user.edit"));
        });
        Breadcrumbs::register("admin.user.destroy", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.user.index");
            $breadcrumbs->push("删除用户", route("admin.user.destroy"));
        });

    //用户角色列表
    Breadcrumbs::register("admin.role.index", function ($breadcrumbs) {
        $breadcrumbs->parent("admin.user.manage");
        $breadcrumbs->push("角色列表", route("admin.role.index"));
    });
        Breadcrumbs::register("admin.role.create", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.role.index");
            $breadcrumbs->push("添加角色", route("admin.role.create"));
        });
        Breadcrumbs::register("admin.role.edit", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.role.index");
            $breadcrumbs->push("编辑角色", route("admin.role.edit"));
        });
        Breadcrumbs::register("admin.role.destroy", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.role.index");
            $breadcrumbs->push("删除角色", route("admin.role.destroy"));
        });

/*
 *文章管理导航路由
 */
Breadcrumbs::register("admin.article.manage", function ($breadcrumbs){
    $breadcrumbs->push("文章管理", route("admin.article.manage"));
});
    //文章列表
    Breadcrumbs::register("admin.article.index", function ($breadcrumbs) {
        $breadcrumbs->parent("admin.article.manage");
        $breadcrumbs->push("文章列表", route("admin.article.index"));
    });
        Breadcrumbs::register("admin.article.create", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.article.index");
            $breadcrumbs->push("添加文章", route("admin.article.create"));
        });
        Breadcrumbs::register("admin.article.edit", function ($breadcrumbs) {
            $breadcrumbs->parent("admin.article.index");
            $breadcrumbs->push("编辑文章", route("admin.article.edit"));
        });
