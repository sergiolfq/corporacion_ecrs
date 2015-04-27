<?php
class queries
{
    // jcombo
    const prc_get_countries = 'CALL Prc_GetCountries';
    const prc_get_states = 'CALL Prc_GetStates';    
    // authentication
    const fnc_register_check = 'SELECT Fnc_RegisterCheck';        
    const prc_login_check = 'CALL Prc_LoginCheck';
    const prc_get_page_auth = 'CALL Prc_GetPageAuth';
    const prc_get_menu_auth = 'CALL Prc_GetMenuAuth';
    const prc_get_users = 'CALL Prc_GetUsers';
    const prc_set_user_name = 'CALL Prc_SetUserName';
    const prc_get_roles = 'CALL Prc_GetRoles';
    const prc_get_all_users = 'CALL Prc_GetAllUsers';
    // menu tree
    const fnc_add_menu_node = 'SELECT Fnc_AddMenuNode';
    const prc_set_menu_node = 'CALL Prc_SetMenuNode';
    const prc_del_menu_node = 'CALL Prc_DelMenuNode';
    const prc_get_menu_children = 'CALL Prc_GetMenuChildren';
    const prc_get_menu_path = 'CALL Prc_GetMenuPath';
    const prc_get_menu_subchildren = 'CALL Prc_GetMenuSubChildren';
    const prc_get_menu_tree = 'CALL Prc_GetMenuTree';            
    // enajenar
    const fnc_add_enaj = 'SELECT Fnc_AddEnaj';
    const prc_get_enajs = 'CALL Prc_GetEnajs';
    const prc_get_enajs_desc = 'CALL Prc_GetEnajsDesc';
    const prc_get_enajs_distr = 'CALL Prc_GetEnajsDistr';
    const prc_get_enajs_sells = 'CALL Prc_GetEnajsSells';
    const prc_get_enajs_servc = 'CALL Prc_GetEnajsServc';
    const prc_get_enajs_by_distribuidor_id = 'CALL Prc_GetEnajsByDistribuidorID';
    const prc_get_enajs_by_usuario_id = 'CALL Prc_GetEnajsByUsuarioID';
    const prc_get_enaj = 'CALL Prc_GetEnaj';
    const fnc_add_user = 'SELECT Fnc_AddUser';
    const fnc_add_fiscalizacion = 'SELECT Fnc_AddFiscalizacion';
    const prc_get_enajs_by_pending = 'CALL Prc_GetEnajsByPending';
}
?>