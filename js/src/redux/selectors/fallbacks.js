import { get } from "lodash";

/**
 * Gets the fallback title from: state.analysisData.snippet.title.
 *
 * @param {Object} state The state object.
 *
 * @returns {string} The fallback title.
 */
export const getTitleFallback = state => get( state, "analysisData.snippet.title", "" );

/**
 * Gets the fallback description from: state.analysisData.snippet.description.
 *
 * @param {Object} state The state object.
 *
 * @returns {string} The fallback description.
 */
export const getDescriptionFallback = state => get( state, "analysisData.snippet.description", "" );

/**
 * Gets the first image from the content in Gutenberg.
 *
 * @param {Object} state The state object.
 *
 * @returns {string} The first content image src.
 */
export const getFirstContentImage = state => {
	const blockIds = state.blocks.order;
	const firstImageId = blockIds.find( id => get( state.blocks.byClientId, `${ id }.name`, "" ) === "core/image" );
	return get( state.blocks.attributes, `${ firstImageId }.src`, "" );
};

/**
 * Gets the fallback image from:
 * state.settings.socialPreviews.sitewideImage
 * or
 * state.snippetEditor.data.snippetPreviewImageURL.
 *
 * @param {Object} state The state object.
 *
 * @returns {string} The sidewide image url.
 */
export const getImageFallback = state => get(
	state,
	"settings.socialPreviews.sitewideImage",
	get( state, "snippetEditor.data.snippetPreviewImageURL", "" )
);

/**
 * Gets the site base URL from the analysisdata state. Then cuts it after the first "/".
 *
 * @param {Object} state The state object.
 *
 * @returns {string} The authorName
 */
export const getSiteUrl = state => ( state.analysisData.snippet.url || "" ).split( "/" )[ 0 ];
