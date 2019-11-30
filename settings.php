<?php
/*  Copyright 2013-2017 Renzo Johnson (email: renzojohnson at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


define( 'QMAPS_VERSION', '1.0.4' );
define( 'QMAPS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'QMAPS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'QMAPS_PLUGIN_NAME', trim( dirname( QMAPS_PLUGIN_BASENAME ), '/' ) );
define( 'QMAPS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );