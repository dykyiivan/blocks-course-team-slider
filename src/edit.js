import { __ } from '@wordpress/i18n';
import { RawHTML } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody,  SelectControl, TextControl } from "@wordpress/components";
import { useSelect, withDispatch, withSelect } from '@wordpress/data';
import '../node_modules/swiper/swiper-bundle.min.js';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {

    const { order, selectedMembers } = attributes;

    const members = useSelect(
        (select) => {
            return select('core').getEntityRecords('postType', 'member', {
                per_page: -1,
                _embed: true,
                order,
            });
        },
        []
    );

    const selectedMembersData = useSelect(
        (select) => {
            return selectedMembers
                ? select('core').getEntityRecords('postType', 'member', { include: selectedMembers, _embed: true })
                : null;
        },
        [selectedMembers]
    );

    const onSelectMembersChange = (values) => {
        setAttributes({ selectedMembers: values });
	 };

	const getPositionValue = (post) => {
		return post.acf && post.acf.position ? post.acf.position : '';
	}

	const getStatusValue = (post) => {
		return post.meta && post.meta['_member_status'] ? post.meta['_member_status'] : '';
	}

	return (
		<>
         <InspectorControls>
                <PanelBody>
                    <SelectControl
                        multiple
                        label={__('Select Team Members')}
                        value={selectedMembers}
                        options={[
                            ...(members
                                ? members.map((member) => ({
                                    label: member.title.rendered,
                                    value: member.id,
                                }))
                                : [])
                        ]}
                        onChange={onSelectMembersChange}
                    />
				</PanelBody>
			</InspectorControls>

			 <div class="swiper swiper-editor">

            <ul {...useBlockProps()} class="swiper-wrapper">
                {(!selectedMembers || selectedMembers.length === 0) &&
                    members &&
                    members.slice(0, 6).map((post) => {
                        const featuredImage =
                            post._embedded &&
                            post._embedded['wp:featuredmedia'] &&
                            post._embedded['wp:featuredmedia'].length > 0 &&
									 post._embedded['wp:featuredmedia'][0];

                        return (
                            <li key={post.id} className='swiper-slide'>
                                {featuredImage && (
                                    <img src={featuredImage.source_url} alt={featuredImage.alt_text} />
                                )}
                                <h5>
                                    <a href={post.link}>
                                        {post.title.rendered ? (
                                            <RawHTML>{post.title.rendered}</RawHTML>
                                        ) : (
                                            <span>{__('No title', 'team-slider')}</span>
                                        )}
                                    </a>
                                </h5>
                                {post.content.rendered && <RawHTML>{post.content.rendered}</RawHTML>}
										  <p>Custom Field</p>
                            </li>

                        );
                    })}

                {selectedMembersData && selectedMembersData.map((post) => {
                    const featuredImage =
                        post._embedded &&
                        post._embedded['wp:featuredmedia'] &&
                        post._embedded['wp:featuredmedia'].length > 0 &&
                        post._embedded['wp:featuredmedia'][0];
                    return (
                        <li key={post.id} class="swiper-slide">
                            {featuredImage && (
                                <img src={featuredImage.source_url} alt={featuredImage.alt_text} />
                            )}
                            <h5>
                                <a href={post.link}>
                                    {post.title.rendered ? (
                                        <RawHTML>{post.title.rendered}</RawHTML>
                                    ) : (
                                        <span>{__('No title', 'team-slider')}</span>
                                    )}
                                </a>
                            </h5>
								  {post.content.rendered && <RawHTML>{post.content.rendered}</RawHTML>}
								  <p>Custom Field</p>
							  </li>
                    );
                })}
					 </ul>
			 </div>
		 </>
	);
}
