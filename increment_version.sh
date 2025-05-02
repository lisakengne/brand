#!/bin/bash

# Fetch the latest tags from the repository
git fetch --tags

# Get the latest tag
latest_tag=$(git describe --tags `git rev-list --tags --max-count=1` 2>/dev/null)

# Check if the latest tag is empty
if [ -z "$latest_tag" ]; then
  # If no tags are found, start with version 1.0.0
  next_version="1.0.0"
else
  # Split the latest tag into major, minor, and patch components
  major=$(echo $latest_tag | cut -d. -f1)
  minor=$(echo $latest_tag | cut -d. -f2)
  patch=$(echo $latest_tag | cut -d. -f3)
  
  # Increment the patch version
  next_patch=$((patch + 1))
  
  # Form the next version string
  next_version="${major}.${minor}.${next_patch}"
fi

# Output the next version
echo "next_version=$next_version"