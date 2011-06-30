<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 0 20px 20px;">
        <div>
            <fieldset>
                <legend>
                    <h1><?php _e('Google Maps Help', 'google_maps'); ?></h1>
                </legend>
                <h2>
                    <?php _e('Show a dragable map in post add page ?', 'google_maps'); ?>
                </h2>
                <p>
                    <?php _e('If you select yes a maps with a draggable pins will show up in the post items page, in that way your user can select there location directly in the map. Longitude and Latitude will be store in database.', 'google_maps'); ?>
                </p>
                <h2>
                    <?php _e('Enter the default point. ', 'google_maps'); ?>
                </h2>
                <p>
                    <?php _e('This is use if you do not use iplocationtools.com service enter the default value to center map.', 'google_maps'); ?>:
                </p>
				<h2>
                    <?php _e('Use iplocationtools.com service? ', 'google_maps'); ?>
                </h2>
                <p>
                    <?php _e('iplocationtools.com is free to use, you only need to sign up to get your api key. They will give you 1000 credits to make 1000 api call but if you put a link on your web site they will give you 1 credit each time there link appear so in clear term is free ! This will return the location of your user with they ip address. Useful if you have more that one city.', 'google_maps'); ?>:
                </p>

				<h2>
                    <?php _e('iplocationtools.com api key. ', 'google_maps'); ?>
                </h2>
                <p>
                    <?php _e('Enter your api key here.', 'google_maps'); ?>:
                </p>

				<p>
                    <a href="http://www.iplocationtools.com" target=_blank>http://www.iplocationtools.com</a>
                </p>
            </fieldset>
        </div>
    </div>
</div>
