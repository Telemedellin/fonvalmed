window.wp = window.wp || {};
window.eml = { l10n: {} };

( function( $, _ ) {
    
    var media = wp.media,
        l10n = media.view.l10n,
        original = {};
 
   

   
    _.extend( eml.l10n, wpuxss_eml_media_views_l10n );



    
    /**
     * media.controller.Library
     *
     */
    _.extend( media.controller.Library.prototype, {    
        
        uploading: function( attachment ) {            
    
            var dateFilter, Filters, taxFilter,
                content = this.frame.content,
                selection = this.get('selection'),
                library = this.get('library');
    
    
            if ( 'upload' === content.mode() ) {
                this.frame.content.mode('browse');
            }
            
            if ( wp.Uploader.queue.length == 1 ) {
            
                dateFilter = content.get().toolbar.get( 'dateFilter' );
                Filters = content.get().toolbar.get( 'filters' );
                
                if ( ! _.isUndefined(dateFilter) && 'all' !== dateFilter.$el.val() ) {
                    dateFilter.$el.val( 'all' ).change();
                }
                
                if ( ! _.isUndefined(Filters) && 'all' !== Filters.$el.val() ) {
                    Filters.$el.val( 'all' ).change();
                }
                
                $.each( eml.l10n.taxonomies, function( taxonomy, values ) {
                            
                    taxFilter = content.get().toolbar.get( taxonomy+'-filter' );
                    
                    if ( ! _.isUndefined(taxFilter) && 'all' !== taxFilter.$el.val() ) {
                        taxFilter.$el.val( 'all' ).change();
                    }
                });
            }
            
            if ( eml.l10n.wp_version < '4.0' || this.get( 'autoSelect' ) ) {                
                
                if ( wp.Uploader.queue.length == 1 && selection.length ) {
                    selection.reset(); 
                }
                selection.add( attachment );
                selection.trigger( 'selection:unsingle', selection.model, selection );
                selection.trigger( 'selection:single', selection.model, selection );
            }    
        }
    });
    
    
    
    
    /**
     * media.view.AttachmentCompat
     *
     */
    var newEvents = { 
        'click input'  : 'preSave'
    };
    
    _.extend( media.view.AttachmentCompat.prototype.events, newEvents );
    
    _.extend( media.view.AttachmentCompat.prototype, {
        
        preSave: function() {
            
            this.noRender = true;
            
            media.model.Query.cleanQueries();
        },
        
        render: function() {
    
            var compat = this.model.get('compat'),
                $compat_el = this.$el;
    
            if ( ! compat || ! compat.item ) {
                return;
            }
            
            if ( this.noRender ) {
                return this;
            }
    
            this.views.detach();
            this.$el.html( compat.item );
            this.views.render();
            
            
            // TODO: find a better solution
            if ( this.controller.isModeActive( 'select' ) && 'edit-attachment' != this.controller.state().get('id') ) {
                
                $.each( eml.l10n.compat_taxonomies_to_hide, function( id, taxonomy ) {
                    $compat_el.find( '.compat-field-'+taxonomy ).remove();
                });
            }

            
            // TODO: find a better solution
            $.each( eml.l10n.compat_taxonomies, function( id, taxonomy ) {
                
                $compat_el.find( '.compat-field-'+taxonomy+' .label' ).addClass( 'eml-tax-label' );
                $compat_el.find( '.compat-field-'+taxonomy+' .field' ).addClass( 'eml-tax-field' );
            });

            return this;
        }
    });
    
    
    
    
    /**
     * media.view.AttachmentFilters
     */    
    _.extend( media.view.AttachmentFilters.prototype, {
        
        change: function() {
            
            var filter = this.filters[ this.el.value ],
                selection = this.controller.state().get( 'selection' ),
                
                $mainFilter = this.controller.$el.find( 'select#media-attachment-filters' ),
                $dateFilter = this.controller.$el.find( 'select#media-attachment-date-filters' ),
                $taxFilters = this.controller.$el.find( 'select.eml-attachment-filters' ),
                resetFilterButton = this.controller.content.get().toolbar.get( 'resetFilterButton' );

                
            if ( filter && selection.length && ! wp.Uploader.queue.length ) {
                selection.reset();
            }
            
            if ( ! $mainFilter.prop( 'selectedIndex' ) && 
                 ! $dateFilter.prop( 'selectedIndex' ) && 
                 ! $taxFilters.filter( function() { return $(this).prop( 'selectedIndex' ) } ).get().length ) {
                resetFilterButton.model.set( 'disabled', true )
            } else {
                resetFilterButton.model.set( 'disabled', false )
            }
            
            if ( filter ) {
                this.model.set( filter.props );
            }
        }
    });
    
    
    

    /**
     * media.view.AttachmentFilters.All 
     */    
    original.AttachmentFilters = {
        
        All: {
            createFilters: media.view.AttachmentFilters.All.prototype.createFilters
        }
    };
    
    _.extend( media.view.AttachmentFilters.All.prototype, {
        
        createFilters: function() {
            
            original.AttachmentFilters.All.createFilters.apply( this, arguments );
            
            _.each( this.filters, function( filter, key ) 
            {
                filter.props['uncategorized'] = null;
            })
            
            this.filters.uncategorized = {
                text:  eml.l10n.uncategorized,
                props: {
                    uploadedTo    : null,
                    uncategorized : true,
                    status        : null,
                    type          : null,
                    orderby       : 'date',
                    order         : 'DESC'
                },
                priority: 60
            };
        },
        
        change: function() {
            
            var filter = this.filters[ this.el.value ],
                $taxFilters = this.controller.$el.find( 'select.eml-attachment-filters' );
            
            media.view.AttachmentFilters.prototype.change.apply( this, arguments );
            
            if ( filter && filter.props.uncategorized &&
                 $taxFilters.filter( function() { return $(this).prop( 'selectedIndex' ) } ).get().length ) {
                     
                $taxFilters.each( function() {
                    if ( this.value != 'all' )
                        $( this ).val( 'all' ).change();
                });
            }
        }
    });
    
    
  
    
    /**
     * media.view.AttachmentFilters.Taxonomy 
     */    
    media.view.AttachmentFilters.Taxonomy = media.view.AttachmentFilters.extend({
        
        id: function() {
            
            return 'media-attachment-'+this.options.taxonomy+'-filters';
        },
        
        className: function() {
            
            // TODO: get rid of excess class name that duplicates id
            return 'attachment-filters eml-attachment-filters attachment-'+this.options.taxonomy+'-filter';
        },
        
        createFilters: function() {
            
            var filters = {},
                self = this;
    
            _.each( self.options.termList || {}, function( term, key ) {
                
                var term_id = term['term_id'],
                    term_name = $("<div/>").html(term['term_name']).text();
                    
                filters[ term_id ] = {
                    text: term_name,
                    props: {},
                    priority: key+4
                };
                
                filters[term_id]['props'][self.options.taxonomy] = term_id;
                
                // TODO: for future sorting inside a ctegory
                // filters[term_id]['props']['orderby'] = 'menuOrder';
                // filters[term_id]['props']['order'] = 'ASC';
            });
            
            filters.all = {
                text: eml.l10n.filter_by + self.options.singularName,
                props: {},
                priority: 1
            };
            
            filters['all']['props'][self.options.taxonomy] = null;
            
            // TODO: for future sorting inside a ctegory
            // filters['all']['props']['orderby'] = 'menuOrder';
            // filters['all']['props']['order'] = 'ASC';
            
            filters.in = {
                text: '— ' + eml.l10n.in + self.options.pluralName + ' —',
                props: {},
                priority: 2
            };
            
            filters['in']['props'][self.options.taxonomy] = 'in';
            
            filters.not_in = {
                text: '— ' + eml.l10n.not_in + self.options.singularName + ' —',
                props: {},
                priority: 3
            };
            
            filters['not_in']['props'][self.options.taxonomy] = 'not_in';
    
            this.filters = filters;
        },
        
        change: function() {
            
            var filter = this.filters[ this.el.value ],
                $mainFilter = this.controller.$el.find( 'select#media-attachment-filters' );
            
            media.view.AttachmentFilters.prototype.change.apply( this, arguments );
            
            if ( filter && 1 != filter.priority && 'uncategorized' == $mainFilter.val() ) {
                $mainFilter.val( 'all' ).change();
            }
        }
    });
    
    
    
    media.view.Button.resetFilters = media.view.Button.extend({
        
        id: 'reset-all-filters',

        click: function( event ) {
            
            if ( '#' === this.attributes.href ) {
				event.preventDefault();
			}
            
            $.each( $('select.attachment-filters'), function() {
                if ( this.value != 'all' )
                    $(this).val( 'all' ).change();
            });
		}
    });
    
    
    
    original.AttachmentsBrowser = {
        
        initialize: media.view.AttachmentsBrowser.prototype.initialize,
        createToolbar: media.view.AttachmentsBrowser.prototype.createToolbar
    };
        
    _.extend( media.view.AttachmentsBrowser.prototype, {
        
        initialize: function() {
            
            original.AttachmentsBrowser.initialize.apply( this, arguments );
            
            this.on( 'ready', this.fixLayout, this );
            
            $( window ).on( 'resize', _.debounce( _.bind( this.fixLayout, this ), 15 ) );
            
            // ACF compatibility
            $( document ).on( 'click', '.acf-expand-details', _.debounce( _.bind( this.fixLayout, this ), 250 ) );
        },
        
        fixLayout: function() {
                
            var $browser = this.$el,
                $attachments = $browser.find('.attachments'),
                $uploader = $browser.find('.uploader-inline'),
                $toolbar = $browser.find('.media-toolbar'),
                $messages = $('.eml-media-css .updated:visible, .eml-media-css .error:visible');
            
            
            if ( eml.l10n.wp_version < '4.0' ) {
                
                if ( 'absolute' == $attachments.css( 'position' ) && 
                    $browser.height() > $toolbar.height() + 20 ) { 
                        
                    $attachments.css( 'top', $toolbar.height() + 20 + 'px' );  
                    $uploader.css( 'top', $toolbar.height() + 20 + 'px' );
                }
                else if ( 'absolute' == $attachments.css( 'position' ) ) {
                    $attachments.css( 'top', '50px' );
                    $uploader.css( 'top', '50px' );
                }
                else if ( 'relative' == $attachments.css( 'position' ) ) {
                    $attachments.css( 'top', '0' );
                    $uploader.css( 'top', '0' );
                }
                
                // TODO: find a better place for it, something like fixLayoutOnce
                $toolbar.find('.media-toolbar-secondary').prepend( $toolbar.find('.instructions') );
                
                return;
            }
            
            
            if ( ! this.controller.isModeActive( 'select' ) && 
                 ! this.controller.isModeActive( 'eml-grid' ) ) {
                return;
            }
    
            if ( this.controller.isModeActive( 'select' ) ) {
                
                $attachments.css( 'top', $toolbar.height() + 10 + 'px' );  
                $uploader.css( 'top', $toolbar.height() + 10 + 'px' );
                $browser.find('.eml-loader').css( 'top', $toolbar.height() + 10 + 'px' );
                
                // TODO: find a better place for it, something like fixLayoutOnce
                $toolbar.find('.media-toolbar-secondary').prepend( $toolbar.find('.instructions') );
            }
    
            if ( this.controller.isModeActive( 'eml-grid' ) ) 
            {
                var messagesOuterHeight = 0;
                
                if ( ! _.isUndefined( $messages ) ) 
                {
                    $messages.each( function() {
                        messagesOuterHeight += $(this).outerHeight( true );
                    });
                    
                    messagesOuterHeight = messagesOuterHeight ? messagesOuterHeight - 20 : 0;
                } 
                
                $browser.css( 'top', $toolbar.outerHeight() + messagesOuterHeight + 20 + 'px' );
                $toolbar.css( 'top', - $toolbar.outerHeight() - 30 + 'px' );
            }
        },
    
        createToolbar: function() {
            
            var filters = this.options.filters,
                self = this,
                i = 1;
            
            original.AttachmentsBrowser.createToolbar.apply( this, arguments );
            
            if ( -1 !== $.inArray( this.options.filters, [ 'uploaded', 'all' ] ) || parseInt( eml.l10n.force_filters ) ) 
            {
                this.toolbar.set( 'filtersLabel', new media.view.Label({
                    value: l10n.filterByType,
                    attributes: {
                        'for':  'media-attachment-filters'
                    },
                    priority:   -80
                }).render() );

                if ( 'uploaded' === this.options.filters ) {
                    this.toolbar.set( 'filters', new media.view.AttachmentFilters.Uploaded({
                        controller: this.controller,
                        model:      this.collection.props,
                        priority:   -80
                    }).render() );
                } else {
                    Filters = new media.view.AttachmentFilters.All({
                        controller: this.controller,
                        model:      this.collection.props,
                        priority:   -80
                    });

                    this.toolbar.set( 'filters', Filters.render() );
                }
    
                if ( eml.l10n.wp_version >= '4.0' ) 
                {
                    this.toolbar.set( 'dateFilterLabel', new media.view.Label({
                        value: l10n.filterByDate,
                        attributes: {
                            'for': 'media-attachment-date-filters'
                        },
                        priority: -75
                    }).render() );
                    this.toolbar.set( 'dateFilter', new media.view.DateFilter({
                        controller: this.controller,
                        model:      this.collection.props,
                        priority: -75
                    }).render() );
                }

                $.each( eml.l10n.taxonomies, function( taxonomy, values ) {
                    
                    if ( values.term_list ) {
                        
                        self.toolbar.set( taxonomy+'FilterLabel', new media.view.Label({
                            value: eml.l10n.filter_by + values.singular_name,
                            attributes: {
                                'for':  'media-attachment-' + taxonomy + '-filters',
                            },
                            priority: -70 + i++
                        }).render() );
                        self.toolbar.set( taxonomy+'-filter', new media.view.AttachmentFilters.Taxonomy({
                            controller: self.controller,
                            model: self.collection.props,
                            priority: -70 + i++,
                            taxonomy: taxonomy, 
                            termList: values.term_list,
                            singularName: values.singular_name,
                            pluralName: values.plural_name
                        }).render() );
                    }
                });
                
                this.toolbar.set( 'resetFilterButton', new media.view.Button.resetFilters({
                    controller: this.controller,
                    text: eml.l10n.reset_filters,
                    disabled: true,
                    priority: -70 + i
                }).render() );
            }
        }
    });
    
    
    
    
    // a copy from media-grid.js | for WP less than 4.1
    if ( _.isUndefined( media.view.DateFilter ) ) {
        media.view.DateFilter = media.view.AttachmentFilters.extend({
            
            id: 'media-attachment-date-filters',
        
            createFilters: function() {
                var filters = {};
                _.each( media.view.settings.months || {}, function( value, index ) {
                    filters[ index ] = {
                        text: value.text,
                        props: {
                            year: value.year,
                            monthnum: value.month
                        }
                    };
                });
                filters.all = {
                    text:  l10n.allDates,
                    props: {
                        monthnum: false,
                        year:  false
                    },
                    priority: 10
                };
                this.filters = filters;
            }
        });
    }
    
    
    
    
    // TODO: move to the PHP side
    $('body').addClass('eml-media-css');

})( jQuery, _ );