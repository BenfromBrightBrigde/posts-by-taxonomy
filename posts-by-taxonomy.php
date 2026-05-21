<?php
/**
 * Posts by Taxonomy
 *
 * @package       POSTSBYTAX
 * @author        Bright Bridge Web
 * @license       gplv2
 * @version       1.0.4
 *
 * @wordpress-plugin
 * Plugin Name:   Posts by Taxonomy
 * Plugin URI:    https://brightbridgeweb.com/custom-plugins/post-by-taxonomy
 * Description:   Display a list separated by any taxonomy via shortcode. Compatible with Search and Filter.
 * Version:       1.0.3
 * Author:        Bright Bridge Web
 * Author URI:    https://brightbridgeweb.com
 * Text Domain:   posts-by-taxonomy
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to:  7.0.0
 * 
 * You should have received a copy of the GNU General Public License
 * along with Posts by Taxonomy. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/*============================================================================================================
 OPTIONAL ATTRIBUTES:
 post-type = post type slug that you wish to loop through, Defaults to WP Blog Posts
 taxonomy = slug to the taxonomy you want to use - Defaults to All
 include = include posts by taxonomy name - Defaults to include all
 post-per-section = number of posts you wish to display per category/tag - Defaults to 3
 fallback = url to the fallback image you would like to display if there is no featured image - Defaults to site logo
 s-and-f = ID of the Search and Filter form you would like to connect
 testing = defaults to false
 exclude = taxonomy items to exclude from displaying - comma separated list of taxonomy id's (ex: 1,2,3,4,1234)
 
  --------------------------------------------------------------------------------------------------------------
  
  EXAMPLES:
  
  Simple display using default settings:
  [bbwd-post-display post-type='Your-Post-Type-Slug']
  
  Simple display in "Test Mode":
  [bbwd-post-display post-type='Your-Post-Type-Slug' testing='true']
  
  Select a specific post type:
  [bbwd-post-display post-type='Your-Post-Type-Slug']
  
  Select a specific post type and use a custom taxonomy:
  [bbwd-post-display post-type='Your-Post-Type-Slug' taxonomy='Your-Tax-Slug']
  
  Select a specific post type, custom taxonomy and add quantity to display per taxonomy:
  [bbwd-post-display post-type='Your-Post-Type-Slug' taxonomy='Your-Tax-Slug' post-per-section=5]
  
  Select a specific post type, custom taxonomy, add quantity to display per taxonomy and add a fallback url:
  [bbwd-post-display post-type='Your-Post-Type-Slug' taxonomy='Your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg']
  
  Select a specific post type, custom taxonomy, add quantity to display per taxonomy, add a fallback url, and display with Search and Filter:
  [bbwd-post-display post-type='Your-Post-Type-Slug' taxonomy='Your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg' s-and-f=123]
  
  Select a specific post type, custom taxonomy, add quantity to display per taxonomy, add a fallback url, display with Search and Filter, and exclude tags:
  [bbwd-post-display post-type='Your-Post-Type-Slug' taxonomy='Your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg' s-and-f=123 exclude='123, 222']
  ============================================================================================================*/

function bbwd_PBTD_enqueu_stuff() {
	wp_register_style( 'bbwd-postbytax-styles', plugins_url( 'posts-by-taxonomy/assets/bbwd-styles.css' ) );
	wp_enqueue_style( 'bbwd-postbytax-styles' );
}
add_action( 'wp_enqueue_scripts', 'bbwd_PBTD_enqueu_stuff' );

add_shortcode('bbwd-post-display', 'bbwd_PBTD_PostDisplay');

function bbwd_PBTD_PostDisplay($bbwdAtts = ''){
	$bbwdDisPosts = 'post';
	$bbwdDisTax = 'category';
	$bbwdFeatFallback = wp_get_attachment_image( get_theme_mod( 'custom_logo' ) );
	$bbwdPostPerSection = -1;
	$bbwdSandF = '';
	$bbwdSandFShort = '';
	$bbwdExcludes = '';
	$bbwdTesting = false;
	$bbwdExFillHTML = ""; 
	foreach($bbwdAtts as $bbwdKey => $bbwdSAt){
		switch ($bbwdKey) {
		  case 'post-type':
			$bbwdDisPosts = $bbwdSAt;
			break;
		  case 'taxonomy':
			$bbwdDisTax = $bbwdSAt;
			break;
		  case 'fallback':
			$bbwdFeatFallback = $bbwdSAt;
			break;
		case 'post-per-section':
			$bbwdPostPerSection = $bbwdSAt;
			break;
		case 's-and-f':
			$bbwdSandF = $bbwdSAt;
			$bbwdSandFShort = "[searchandfilter id='$bbwdSAt']";
			break;
		case 'testing':
			$bbwdTesting = true;
			break;
		case 'exclude':
			$bbwdExcludes = explode(',', $bbwdSAt);
			break;
		}
		$bbwdExFillHTML .= "$bbwdSandFShort<div id='bbwd-post-master'>";
		$bbwdSanPosts = array();
		$bbwdAllterms = get_terms([
							'taxonomy' => $bbwdDisTax,
							'hide_empty' => false,
							'exclude' => 'all'
						]);
		$testFPInt = 0;
		$testCPInt = 0;
		foreach($bbwdAllterms as $bbwdSTerm){
			$bbwdPostsArgs = array('post_status'=>'publish', 'post_type'=>$bbwdDisPosts, 'post-per-page'=>$bbwdPostPerSection, 'tax_query'=>array(array('taxonomy'=>$bbwdDisTax, 'field'=>'name', 'terms' => array($bbwdSTerm->name))));
			if($bbwdSandF != ''){
				$bbwdPostsArgs['search_filter_id'] = $bbwdSandF;
			} 
			$bbwdPostsToDisplay = new WP_Query($bbwdPostsArgs);
			if($bbwdPostsToDisplay->found_posts > 0){
				$testFPInt += $bbwdPostsToDisplay->found_posts;
				$bbwdExFillHTML .= "<div class='bbwd-tag-wrap'>";
				$bbwdExFillHTML .= "<div class='bbwd-flex bbwd-full-center bbwd-title-container'><div class='bbwd-tag-line'></div><h5 class='bbwd-post-tag-title'>$bbwdSTerm->name</h5><div class='bbwd-tag-line'></div></div>";
				foreach($bbwdPostsToDisplay->posts as $bbwdPost){
					$bbwdPostInArray = in_array($bbwdPost->ID, $bbwdSanPosts);
					if(!$bbwdPostInArray){
						$testCPInt++;
						$bbwdExFillHTML .= "<div class='bbwd-post-child'>";
						$bbwdPostTitle = get_the_title($bbwdPost);
						$bbwdPostRawC = $bbwdPost->post_content;
						$bbwdPostContent = wp_trim_words( $bbwdPostRawC, 30 );//strtok(wordwrap($bbwdPost->post_content, 200, "...\n"), "\n");
						$bbwdPostExcerpt = strtok(wordwrap($bbwdPost->post_excerpt, 250, "...\n"), "\n"); 
						$bbwdPostPermalink = get_permalink($bbwdPost);
						if($bbwdPostExcerpt == null || $bbwdPostExcerpt == ''){ $bbwdPostExcerpt = $bbwdPostContent; }
						$bbwdPostCrDate = get_the_date('', $bbwdPost);
						$bbwdPostFeat = get_the_post_thumbnail($bbwdPost, 'large');
						$bbwdPostTerms = get_the_terms($bbwdPost, $bbwdDisTax);
						if($bbwdPostFeat == null || $bbwdPostFeat == ""){ $bbwdPostFeat = $bbwdFeatFallback; }
						$bbwdIcons ="<div class='elementor-grid'><div class='elementor-grid-item'><div class='elementor-share-btn elementor-share-btn_facebook' role='button' tabindex='0' aria-label='Share on facebook'><span class='elementor-share-btn__icon'><i class='fab fa-facebook' aria-hidden='true'></i></span></div></div><div class='elementor-grid-item'><div class='elementor-share-btn elementor-share-btn_twitter' role='button' tabindex='0' aria-label='Share on twitter'><span class='elementor-share-btn__icon'><i class='fab fa-twitter' aria-hidden='true'></i></span></div></div><div class='elementor-grid-item'><div class='elementor-share-btn elementor-share-btn_linkedin' role='button' tabindex='0' aria-label='Share on linkedin'><span class='elementor-share-btn__icon'><i class='fab fa-linkedin' aria-hidden='true'></i></span></div></div></div>";
						array_push($bbwdSanPosts, $bbwdPost->ID);
						$bbwdExFillHTML .= "<div class='bbwd-post-inner bbwd-flex'><a class='bbwd-feat-link' href='$bbwdPostPermalink'><div class='bbwd-post-image'>$bbwdPostFeat</div></a><div class='bbwd-flex bbwd-post-data'><a href='$bbwdPostPermalink'><h2 class='bbwd-dis-title'>$bbwdPostTitle</h2><p class='bbwd-post-excerpt'>$bbwdPostExcerpt</p><p class='bbwd-post-date'>$bbwdPostCrDate</p></a></div></div></div>";
					}
				}
				$bbwdExFillHTML .= "</div>";
			}
		}
		$bbwdExFillHTML .= "</div><div id='bbwd-final-res'></div>";
		if($bbwdTesting){
			$bbwdPostType = isset($bbwdAtts['post-type']) ? "Post type selected = ".$bbwdAtts['post-type'] : "No post type selected" ;
			$bbwdTaxSelected = isset($bbwdAtts['taxonomy']) ? "Taxonomy selected = ".$bbwdAtts['taxonomy'] : "No taxonomy selected" ;
			$bbwdPostPerSec = isset($bbwdAtts['post-per-section']) ? $bbwdAtts['post-per-section']." posts per section" : "No limit set on post per section" ;
			$bbwdFallBackUrl = isset($bbwdAtts['fallback-image']) ? "Fallback url = ".$bbwdAtts['fallback-image'] : "No fallback image selected" ;
			$bbwdSandFID = isset($bbwdAtts['s-and-f']) ? "Search and Filter ID = ".$bbwdAtts['s-and-f'] : "No Search and Filter id selected" ;
			$bbwdRawExludes = isset($bbwdAtts['exclude']) ? $bbwdAtts['exclude']." are excluded" : "No excluded taxonomy items" ;
			$testPCount = sizeof($bbwdPostsToDisplay->posts);
			echo "<p>".esc_html($bbwdPostType)."</p>";
			echo "<p>".esc_html($bbwdTaxSelected)."</p>";
			echo "<p>".esc_html($bbwdPostPerSec)."</p>";
			echo "<p>".esc_html($bbwdSandFID)."</p>";
			echo "<p>".esc_html($bbwdFallBackUrl)."</p>";
			echo "<p>".esc_html($bbwdRawExludes)."</p>";
			echo "<p>".esc_html($testFPInt)." Total $bbwdDisPosts returned</p>";
			echo "<p>".esc_html($testCPInt)." Total $bbwdDisPosts count currently displayed</p>";
		}
	}
    return $bbwdExFillHTML;
}