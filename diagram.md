tables
[
    - categories: rooms, furniture, cabinets;
    - members: persons;
    - properties: properties, purchases
    - financials: financials => [outgoings, incomes];
]

    - main_projects [
        - id
        - unique_name or email
    ]

    - 
    /** not used
        - types[
            - id
            - name (container, closet)
        ]
     */

    - categories [
        - id
        - name
        - parent_id
        - type // not used
    ]

    - positions [
        - id
        - name
    ]

    - members [
        - id
        - name
        - position_id
    ]
