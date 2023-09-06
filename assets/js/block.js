const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, ToggleControl } = wp.components;
const { useEffect } = wp.element;

registerBlockType('custom-miusage-block/miusage-block', {
    title: 'Varun Miusage Block',
    icon: 'smiley',
    category: 'common',
    attributes: {
        content: {
            type: 'array',
            default: values.varun_content,
        },
        columnVisibility: {
            type: 'object',
            default: {},
        },
    },
    
    edit: function ({ attributes, setAttributes }) {
        const { content, columnVisibility } = attributes;

        // Function to toggle column visibility
        const toggleColumnVisibility = (columnName, index) => {
            setAttributes({
                columnVisibility: {
                    ...columnVisibility,
                    [columnName]: !columnVisibility[columnName],
                    [index]: !columnVisibility[index],
                },
            });
        };

        useEffect(() => {
            const url = '/wp-admin/admin-ajax.php?action=varun_content_api_fetch';

            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then((data) => {
                setAttributes({ content: data });
            })
            .catch((error) => console.error('Error:', error));
        }, []);

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Column Visibility">
                        {content.data.headers.map((header, index) => (
                            <ToggleControl
                                key={header}
                                label={`Show ${header}`}
                                checked={columnVisibility[header]}
                                onChange={() => toggleColumnVisibility(header, index + 1)}
                            />
                        ))}
                    </PanelBody>
                </InspectorControls>
                {renderVarunMiusageBlock(content, columnVisibility)}
            </>
        );
    },
    save: function ({ attributes }) {
        const { content, columnVisibility } = attributes;
        return renderVarunMiusageBlock(content, columnVisibility);
    },
});

const renderVarunMiusageBlock = (content, columnVisibility) => (
    <div className="varun_miusage">
        <h1>{content.title}</h1>
        <table>
            <thead>
                <tr>
                    {content.data.headers.map((header, index) => (
                        columnVisibility[header] && <th key={header}>{header}</th>
                    ))}
                </tr>
            </thead>
            <tbody>
                    {Object.values(content.data.rows).map((row,index) => (
                   <tr key={row.id}>
                        { columnVisibility[1] && <td>{row.id}</td> }
                        { columnVisibility[2] && <td>{row.fname}</td> }
                        { columnVisibility[3] && <td>{row.lname}</td> }
                        { columnVisibility[4] && <td>{row.email}</td> }
                        { columnVisibility[5] && <td>{new Date(row.date * 1000).toDateString()}</td> }
                    </tr>
                    ))}
                </tbody> 
        </table>
    </div>
);
