<?php
// Heading
$_['heading_error_log']    = 'Virhetiedot';
$_['heading_settings']     = 'Settings and Maintainance';
$_['heading_title']        = 'VQMod Manager';
$_['heading_vqmods']       = 'VQMod Scripts';

// Columns
$_['column_action']        = 'Asenna / Poista';
$_['column_author']        = 'Laatija';
$_['column_delete']        = 'Poista';
$_['column_file_name']     = 'Tiedoston nimi:';
$_['column_id']            = 'Nimi / Kuvaus';
$_['column_status']        = 'Tila';
$_['column_version']       = 'Versio';
$_['column_vqmver']        = 'VQMod Versio';

// Entry
$_['entry_backup']         = 'Backup VQMod Scripts:';
$_['entry_ext_version']    = 'VQMod Manager Versio:';
$_['entry_status']         = 'VQMod Manager Tila:';
$_['entry_upload']         = 'VQMod Lataus:';
$_['entry_vqmod_path']     = 'VQMod Path:';
$_['entry_vqcache']        = 'VQMod Cache:';
$_['entry_use_cache']      = 'Output Caching:';

// Text
$_['text_autodetect']      = 'VQMod appears to be installed at the following path. Press Save to confirm path and complete installation.';
$_['text_autodetect_fail'] = 'Unable to detect VQMod installation.  Please download and install the <a href="http://code.google.com/p/vqmod/downloads/list" target="_blank">latest version</a> or enter the non-standard server installation path.';
$_['text_delete']          = 'Poista';
$_['text_disabled']        = 'Ei k&auml;yt&ouml;ss&auml;';
$_['text_enabled']         = 'K&auml;yt&ouml;ss&auml;';
$_['text_install']         = 'Asenna';
$_['text_module']          = 'Moduuli';
$_['text_no_results']      = 'No VQMod scripts were found!';
$_['text_success']        = 'Suorite: Asetukset on tallennettu onnistuneesti!';
$_['text_unavailable']     = '&mdash;';
$_['text_uninstall']       = 'Poista';
$_['text_vqcache_help']    = 'Some system files will always be present even after clearing the cache.';
$_['text_vqmod_path']      = 'VQMod hakemistopolku';

// Button
$_['button_backup']        = 'Backup';
$_['button_cancel']        = 'Keskeyt&auml;';
$_['button_clear']         = 'Clear';
$_['button_save']          = 'Tallenna';
$_['button_upload']        = 'Upload';

// Error
$_['error_delete']         = 'Warning: Unable to delete VQMod script!';
$_['error_filetype']       = 'Varoitus: Tiedostotyyppi ei kelpaa! Lataa ainoastaan .xml tiedostoja.';
$_['error_install']        = 'Warning: Unable to install VQMod script!';
$_['error_invalid_xml']    = 'Warning: VQMod script XML syntax does not appear to be valid!';
$_['error_log_size']       = 'Warning: Your VQMod error log is %sMBs.  The limit for VQMod Manager is 6MB.  If you need to view the errors you should download the log by FTP.  Otherwise consider clearing it below.';
$_['error_moddedfile']     = 'Warning: VQMod script attempts to mod file \'%s\' which does not appear to exist!';
$_['error_move']           = 'Warning: Unable to save file on server.  Please check directory permissions.';
$_['error_permission']     = 'Varoitus: Sinulla ei ole vaadittavia oikeuksia suorittaa toimintoa!';
$_['error_uninstall']      = 'Warning: Unable to uninstall VQMod script!';

// $_FILE Upload Errors
$_['error_form_max_file_size']   = 'Warning: VQMod script exceeds max allowable size!';
$_['error_ini_max_file_size']    = 'Warning: VQMod script exceeds max php.ini file size!';
$_['error_no_temp_dir']          = 'Warning: No temporary directory found!';
$_['error_no_upload']            = 'Warning: No file selected for upload!';
$_['error_partial_upload']       = 'Warning: Upload incomplete!';
$_['error_php_conflict']         = 'Warning: Unknown PHP conflict!';
$_['error_unknown']              = 'Warning: Unknown error!';
$_['error_write_fail']           = 'Warning: Failed to write VQMod script!';

// VQMod Log Errors
$_['error_mod_aborted']          = 'Mod Aborted';
$_['error_mod_skipped']          = 'Operation Skipped';

// Success
$_['success_clear_cache']        = 'Suorite: VQMod cache cleared!';
$_['success_clear_log']          = 'Suorite: VQMod error log cleared!';
$_['success_delete']             = 'Suorite: VQMod script deleted!';
$_['success_install']            = 'Suorite: VQMod script installed!';
$_['success_uninstall']          = 'Suorite: VQMod script uninstalled!';
$_['success_upload']             = 'Suorite: VQMod script uploaded!';

// Javascript Warnings
$_['warning_required_delete']    = 'WARNING: Deleting \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING! Continue?';
$_['warning_required_uninstall'] = 'WARNING: Uninstalling \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING! Continue?';
$_['warning_vqmod_delete']       = 'WARNING: Deleting a VQMod script cannot be undone! Are you sure you want to do this?';

// Version
$_['vqmod_manager_version']      = '1.0.1';
?>